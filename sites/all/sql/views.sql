
CREATE or replace view view_channel_has_item
AS select
   r.rid AS rid,
   r.vid AS vid,
   r.uid AS uid,
   r.created AS created,
   r.changed AS changed,
   fde0.endpoints_entity_id AS channel_nid,
   n0.title as channel_title,
   n0.status as channel_status,
   fde1.endpoints_entity_id AS item_nid,
   n1.title as item_title,
   n1.status as item_status,
   n1.created as item_created,
   n1.changed as item_changed
from
  relation r
  left join field_data_endpoints fde0 on (r.rid = fde0.entity_id) and (fde0.endpoints_r_index = 0)
  left join field_data_endpoints fde1 on (r.rid = fde1.entity_id) and (fde1.endpoints_r_index = 1)
  left join node n0 on (fde0.endpoints_entity_id = n0.nid)
  left join node n1 on (fde1.endpoints_entity_id = n1.nid)
where r.relation_type = 'has_item';


CREATE or replace view view_channel_has_subscriber
AS select
   r.rid AS rid,
   r.vid AS vid,
   r.uid AS uid,
   r.created AS created,
   r.changed AS changed,
   fde0.endpoints_entity_id AS channel_nid,
   n.title as channel_title,
   n.status as channel_status,
   fde1.endpoints_entity_id AS subscriber_uid,
   u.name as subscriber_name,
   u.status as subscriber_status,
   field_email_notification_value as email_notification
from
  relation r
  left join field_data_endpoints fde0 on (r.rid = fde0.entity_id) and (fde0.endpoints_r_index = 0)
  left join field_data_endpoints fde1 on (r.rid = fde1.entity_id) and (fde1.endpoints_r_index = 1)
  left join field_data_field_email_notification fen on fen.entity_id = r.rid
  left join node n on fde0.endpoints_entity_id = n.nid
  left join users u on fde1.endpoints_entity_id = u.uid
where r.relation_type = 'has_subscriber';


CREATE or replace view view_entity_has_channel
AS select
   r.rid AS rid,
   r.vid AS vid,
   r.uid AS uid,
   r.created AS created,
   r.changed AS changed,
   fde0.endpoints_entity_type AS entity_type,
   fde0.endpoints_entity_id AS entity_id,
   fde1.endpoints_entity_id AS channel_nid
from
  relation r
  left join field_data_endpoints fde0 on (r.rid = fde0.entity_id) and (fde0.endpoints_r_index = 0)
  left join field_data_endpoints fde1 on (r.rid = fde1.entity_id) and (fde1.endpoints_r_index = 1)
where r.relation_type = 'has_channel';


CREATE or replace view view_group
AS select
   n.nid,
   n.title,
   n.status,
   n.uid,
   n.created,
   n.changed,
   fd.field_description_value as description,
   fgt.field_group_type_value as group_type,
   fs.field_scale_tid as scale_tid,
   ttd.name as scale_name,
   if (sum(vgm.member_status) is NULL, 0, sum(vgm.member_status)) as member_count
from
  node n
  left join field_data_field_description fd on n.nid = fd.entity_id
  left join field_data_field_group_type fgt on n.nid = fgt.entity_id
  left join field_data_field_scale fs on n.nid = fs.entity_id
  left join taxonomy_term_data ttd on fs.field_scale_tid = ttd.tid
  left join view_group_has_member vgm on n.nid = vgm.group_nid
where type = 'group'
group by n.nid


CREATE or replace view view_group_has_member
AS select
   r.rid AS rid,
   r.vid AS vid,
   r.uid AS uid,
   r.created AS created,
   r.changed AS changed,
   fde0.endpoints_entity_id AS group_nid,
   n.title AS group_title,
   n.status AS group_status,
   fde1.endpoints_entity_id AS member_uid,
   u.name AS member_name,
   u.status AS member_status,
   field_is_admin_value AS is_admin
from
  relation r
  left join field_data_endpoints fde0 on ((r.rid = fde0.entity_id) and (fde0.endpoints_r_index = 0))
  left join field_data_endpoints fde1 on ((r.rid = fde1.entity_id) and (fde1.endpoints_r_index = 1))
  left join field_data_field_is_admin ia on r.rid = ia.entity_id
  left join node n on fde0.endpoints_entity_id = n.nid
  left join users u on fde1.endpoints_entity_id = u.uid
where r.relation_type = 'has_member';


CREATE or replace view view_followers
AS select
   r.rid AS rid,
   r.vid AS vid,
   r.uid AS uid,
   r.created AS created,
   r.changed AS changed,
   fde0.endpoints_entity_id AS follower_uid,
   u0.name AS follower_name,
   u0.status AS follower_status,
   fde1.endpoints_entity_id AS followee_uid,
   u1.name AS followee_name,
   u1.status AS followee_status
from
  relation r
  left join field_data_endpoints fde0 on ((r.rid = fde0.entity_id) and (fde0.endpoints_r_index = 0))
  left join field_data_endpoints fde1 on ((r.rid = fde1.entity_id) and (fde1.endpoints_r_index = 1))
  left join users u0 on fde0.endpoints_entity_id = u0.uid
  left join users u1 on fde1.endpoints_entity_id = u1.uid
where r.relation_type = 'follows';


CREATE or replace view view_member
AS select
   u.uid,
   u.name,
   u.mail,
   u.created,
   u.status,
   ffn.field_first_name_value as first_name,
   fln.field_last_name_value as last_name,
   fdob.field_date_of_birth_value as date_of_birth,
   fg.field_gender_value as gender,
   fb.field_bio_value as bio,
   fmp.field_mobile_phone_value as mobile_phone,
   fmm.field_moon_or_mars_value as moon_or_mars,
   upper(l.country) as country,
   l.province as province,
   l.city as city,
   snm.field_site_new_member_nxn_value as site_member_nxn,
   sng.field_site_new_group_nxn_value as site_group_nxn,
   sni.field_site_new_item_nxn_value as site_item_nxn,
   snc.field_site_new_comment_nxn_value as site_comment_nxn,
   cni.field_channel_new_item_nxn_value as channel_item_nxn,
   cnc.field_channel_new_comment_nxn_value as channel_comment_nxn,
   fni.field_followee_new_item_nxn_value as followee_item_nxn,
   fnc.field_followee_new_comment_nxn_value as followee_comment_nxn,
   gni.field_group_new_item_nxn_value as group_item_nxn,
   gnc.field_group_new_comment_nxn_value as group_comment_nxn
from
  users u
  left join field_data_field_first_name ffn on u.uid = ffn.entity_id
  left join field_data_field_last_name fln on u.uid = fln.entity_id
  left join field_data_field_date_of_birth fdob on u.uid = fdob.entity_id
  left join field_data_field_gender fg on u.uid = fg.entity_id
  left join field_data_field_bio fb on u.uid = fb.entity_id
  left join field_data_field_mobile_phone fmp on u.uid = fmp.entity_id
  left join field_data_field_moon_or_mars fmm on u.uid = fmm.entity_id
  left join field_data_field_user_location ful on u.uid = ful.entity_id
  left join location l on ful.field_user_location_lid = l.lid
  left join field_data_field_site_new_member_nxn snm on u.uid = snm.entity_id
  left join field_data_field_site_new_group_nxn sng on u.uid = sng.entity_id
  left join field_data_field_site_new_item_nxn sni on u.uid = sni.entity_id
  left join field_data_field_site_new_comment_nxn snc on u.uid = snc.entity_id
  left join field_data_field_channel_new_item_nxn cni on u.uid = cni.entity_id
  left join field_data_field_channel_new_comment_nxn cnc on u.uid = cnc.entity_id
  left join field_data_field_followee_new_item_nxn fni on u.uid = fni.entity_id
  left join field_data_field_followee_new_comment_nxn fnc on u.uid = fnc.entity_id
  left join field_data_field_group_new_item_nxn gni on u.uid = gni.entity_id
  left join field_data_field_group_new_comment_nxn gnc on u.uid = gnc.entity_id;


CREATE or replace VIEW view_relationship
AS select
   r.rid AS rid,
   r.relation_type AS relation_type,
   r.vid AS vid,
   r.uid AS uid,
   r.created AS created,
   r.changed AS changed,
   r.arity AS arity,
   fde0.deleted AS deleted0,
   fde0.language AS language0,
   fde0.delta AS delta0,
   fde0.endpoints_entity_type AS entity_type0,
   fde0.endpoints_entity_id AS entity_id0,
   fde0.endpoints_r_index AS r_index0,
   fde1.deleted AS deleted1,
   fde1.language AS language1,
   fde1.delta AS delta1,
   fde1.endpoints_entity_type AS entity_type1,
   fde1.endpoints_entity_id AS entity_id1,
   fde1.endpoints_r_index AS r_index1
from
  relation r
  left join field_data_endpoints fde0 on ((r.rid = fde0.entity_id) and (fde0.endpoints_r_index = 0))
  left join field_data_endpoints fde1 on ((r.rid = fde1.entity_id) and (fde1.endpoints_r_index = 1));
