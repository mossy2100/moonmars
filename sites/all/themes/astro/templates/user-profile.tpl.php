<?php
// If this is the member's own profile, include the filter checkbox:
if ($viewing_own_profile) {
  echo render(drupal_get_form('moonmars_members_filter_channel_form'));
}

// Render the member's channel:
echo render_node($channel);
