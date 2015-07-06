-- view_all
SELECT ph.id, ph.id_users, ph.title, ph.hand, ph.thinkingprocess, ph.image1, ph.image2, ph.date, ph.enable as hands_enable, us.login, us.enable as users_enable, cl.id as id_class, cl.nom as classification
FROM tgt_posthands as ph, tgt_users as us, classification as cl
where ph.id_users = us.id and ph.id_class = cl.id