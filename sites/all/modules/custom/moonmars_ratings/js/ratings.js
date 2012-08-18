var $ = jQuery;


$(function() {

  $('.rating-button').click(function() {
    // Show the waiting icon:
    $(this).closest('.post-controls').addClass('waiting');

    var entity_type = $(this).parent('.rating-buttons').attr('data-entity-type');
    var entity_id = $(this).parent('.rating-buttons').attr('data-entity-id');
    var rating = $(this).attr('data-rating');
    $.post("/ajax/rate", {entity_type: entity_type, entity_id: entity_id, rating: rating}, rateEntityReturn, 'json');
  });

});

function rateEntityReturn(data, textStatus, jqXHR) {
  // Hide the waiting icon:
  var buttons = $('#rating-buttons-' + data.entity_type + '-' + data.entity_id);
  buttons.closest('.post-controls').removeClass('waiting');

  if (!data.result) {
    alert(data.error);
  }
  else {
    // Change which button is selected:
    buttons.find('.rating-button').removeClass('selected');
    buttons.find('.rating-button-' + data.entity.new_rating_name).addClass('selected');

    // Update the entity's score:
    $('.score-' + data.entity_type + '-' + data.entity_id).text(data.entity.new_score);

    // Update the rater's score:
    if (data.rater.new_score !== undefined) {
      $('.score-user-' + data.rater.uid).text(data.rater.new_score);
    }

    // Update the poster's score:
    if (data.poster.new_score !== undefined) {
      $('.score-user-' + data.poster.uid).text(data.poster.new_score);
    }

    // Update the group's score:
    if (data.group !== undefined && data.group.new_score !== undefined) {
      $('.score-node-' + data.group.nid).text(data.group.new_score);
    }
  }
}
