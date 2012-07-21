/**
 * Provide Chatroom chatbar functionality.
 */
(function ($) {

Drupal.ChatroomChatbar = Drupal.ChatroomChatbar || {'chats': {}};

/**
 * We depend on the Nodejs module successfully create a socket for us.
 */
Drupal.Nodejs.connectionSetupHandlers.chatroomUser = {
  connect: function () {
    $('body').append(Drupal.settings.chatroom.userBar.html);
    $('.chatroom-chatbar-start-chat-link').live('click', function (e) {
      e.preventDefault();
      e.stopPropagation();
      var toUid = this.href.replace(/.*(\d+)/, '$1');
      var fromUid = Drupal.settings.chatroom.uid;
      var options = {
        title: 'Chatbar chat between uid ' + toUid + ' and ' + fromUid,
      };
      console.log(options);
      Drupal.chatroom.createChat(options, function (data) {
        data.buddyUid = toUid;
        Drupal.ChatroomChatbar.createChat(data);
      });
    });
    $('#chatroom-chatbar-chatbar .chatroom-chatbar-tab-button').live('click', function () {
      Drupal.ChatroomChatbar.clickChat(this);
    });
  }
}

/**
 * We depend on Nodejs presence notifications.
 */
Drupal.Nodejs.presenceCallbacks.chatbarBuddyList = {
  callback: function (message) {
    console.log(message);
  }
};

Drupal.Nodejs.callbacks.chatroomBuddyAddMessage = {
  callback: function (message) {
    if ($('#chatroom-chatbar-chat-' + message.data.chatId).length == 0) {
      Drupal.ChatroomChatbar.createChat(message);
    }
    Drupal.ChatroomChatbar.updateChat(message);
  }
};

Drupal.ChatroomChatbar.createChat = function (data) {
  Drupal.ChatroomChatbar.chats[data.cid] = {buddyUid: data.buddyUid};

  var html = '<div id="chatroom-chatbar-chat-' + data.cid + '" class="chatroom-chatbar-section-container">';
  html += '<a class="chatroom-chatbar-tab-button">' + data.buddyUid + '</a>';
  html += '<div class="chatroom-chatbar-chatbar-pane chatroom-chatbar-chatbar-chat"><h2>Chat with ' + data.buddyUid + '</h2>';
  html += '<div id="chatroom-chatbar-message-board-' + data.cid + '" class="chatroom-chatbar-chatbar-message-board"></div>';
  html += '<div class="chatroom-chatbar-chatbar-message-box"><input id="chatroom-chatbar-message-box-' + data.cid + '" type="text" name="' + data.cid + '" /></div>';
  html += '</div></div>';
  $('#chatroom-chatbar-chatbar').append(html);

  $('#chatroom-chatbar-message-box-' + data.cid).keyup(function(e) {

    var messageText = $(this).val().replace(/^\s+|\s+$/g, '');
    var cid = this.id.match(/chatroom-chatbar-message-box-(\d+)/)[1];
    if (messageText && e.keyCode == 13 && !e.shiftKey && !e.ctrlKey) {
      Drupal.chatroom.postMessage(messageText, '', Drupal.settings.chatroom.chats[cid]);
      $(this).val('').focus();
    }
    else {
      return true;
    }
  });

  Drupal.ChatroomChatbar.popupChat(data.cid);
  if (data.creatorUid > 0) {
    $('#chatroom-chatbar-message-box-' + data.cid).focus();
  }
};

Drupal.ChatroomChatbar.updateChat = function (message) {
  Drupal.ChatroomChatbar.popupChat(message.data.chatId);
  $(message.data.html).hide().appendTo('#chatroom-chatbar-message-board-' + message.data.chatId).fadeIn(200);
  $('#chatroom-chatbar-message-board-' + message.data.chatId).animate({ scrollTop: $('#chatroom-chatbar-message-board-' + message.data.chatId).attr("scrollHeight") }, 200);
};

Drupal.ChatroomChatbar.chatWithBuddyExists = function (buddyUid) {
  for (var i in Drupal.ChatroomChatbar.chats) {
    if (Drupal.ChatroomChatbar.chats[i].buddyUid == buddyUid) {
      return true;
    }
  }
  return false;
};

Drupal.ChatroomChatbar.getChatIdFromBuddyId = function (buddyUid) {
  for (var i in Drupal.ChatroomChatbar.chats) {
    if (Drupal.ChatroomChatbar.chats[i].buddyUid == buddyUid) {
      return i;
    }
  }
  return false;
};

Drupal.ChatroomChatbar.popupChat = function (chatId) {
  console.log('Drupal.ChatroomChatbar.popupChat', chatId);
  var container = $('#chatroom-chatbar-chat-' + chatId);
  if (container.children('.chatroom-chatbar-chatbar-pane').css('display') == 'none') {
    container.children('.chatroom-chatbar-tab-button').first().click();
  }
};

Drupal.ChatroomChatbar.clickChat = function (button) {
  var sibling_pane = $(button).siblings('.chatroom-chatbar-chatbar-pane');
  var container = $(button).parent();

  if (container.width() > sibling_pane.width()) {
    sibling_pane.width(container.width());
  }
  else {
    container.width(sibling_pane.width());
  }
  sibling_pane.width(container.width());

  // reposition all the chats
  $('#chatroom-chatbar-chatbar').children().each(function(index, chatContainer) {
    var chatbarPane = $(chatContainer).children('.chatroom-chatbar-chatbar-pane');
    chatbarPane.offset({'left' : $(chatContainer).offset().left});
  });

  sibling_pane.slideToggle(100, function() {
    if ($(this).css('display') == 'none') {
      container.width('auto');

      // reposition all the chats... again... really? Come on...
      $('#chatroom-chatbar-chatbar').children().each(function(index, chatContainer) {
        var chatbarPane = $(chatContainer).children('.chatroom-chatbar-chatbar-pane');
        chatbarPane.offset({'left' : $(chatContainer).offset().left});
      });

    }
  });
};

})(jQuery);

// vi:ai:expandtab:sw=2 ts=2

