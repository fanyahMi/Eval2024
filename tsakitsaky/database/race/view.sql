create or replace view v_temps_global_coureur as
SELECT
    ROW_NUMBER() OVER (PARTITION BY c.etape_id ORDER BY t.heure_arriver - t.heure_depart) AS rang_coureur,
    t.id_temps_coureur_etape,
    coalesce(t.coureur_etape_id, id_coureur_etape) as coureur_etape_id,
    c.etape_id,
    et.etape,
    et.nb_coureur,
    et.rang,
    cr.equipe,
    eq.nom as equipe_libelle,
    c.coureur_id,
    cr.nom,
    coalesce(t.date_cours, null) as date_cours,
    coalesce(t.heure_depart, null) as heure_depart,
    coalesce(t.heure_arriver, null) as heure_arriver,
    coalesce(t.penalite, 0) as penalite,
    coalesce(EXTRACT(HOUR FROM (t.heure_arriver - t.heure_depart)),0) AS difference_hours,
    coalesce(EXTRACT(MINUTE FROM (t.heure_arriver - t.heure_depart)),0) AS difference_minutes,
    coalesce(EXTRACT(SECOND FROM (t.heure_arriver - t.heure_depart)),0) AS difference_seconds,
    coalesce(EXTRACT(EPOCH FROM (t.heure_arriver - t.heure_depart)),0) AS difference_seconds_total
FROM
    temps_coureur_etape t
right JOIN
    coureur_etape c ON c.id_coureur_etape = t.coureur_etape_id
JOIN
    coureur cr ON cr.id_coureur = c.coureur_id
JOIN
    utilisateur eq ON eq.id_utilisateur = cr.equipe
join
    etapes et on et.id_etape = c.etape_id
ORDER BY
    et.rang, difference_seconds_total ASC;

create or replace view v_classement_coureur as
select
    g.rang_coureur,
    g.coureur_etape_id,
    g.etape_id,
    g.etape,
    g.equipe,
    g.equipe_libelle,
    g.nom,
    g.date_cours,
    g.heure_depart,
    g.heure_arriver,
    g.penalite,
    g.difference_hours,
    g.difference_minutes,
    g.difference_seconds,
    g.difference_seconds_total,
    case
        when g.heure_arriver is null then 0
        else coalesce(p.points, 0)
    end as points
from
    v_temps_global_coureur g
    left join
    point_classement p on p.id_point_classement = g.rang_coureur
order by
    etape_id, rang_coureur;
/*
 select
    *
    from v_classement_coureur
    where difference_seconds_total = 0;

----------------------------------------------
create or replace view v_classement_equipe_etape as
SELECT
    c.etape_id,
    c.etape,
    c.equipe,
    c.equipe_libelle,
    sum(points) AS total_points,
    ROW_NUMBER() OVER (PARTITION BY c.etape_id ORDER BY sum(points) DESC) AS rang
FROM
    v_classement_coureur c
GROUP BY
    c.etape_id, c.etape, c.equipe, c.equipe_libelle
ORDER BY
    c.etape_id;

---------------------------------------------------

create or replace view v_classement_equipe as
select
    c.equipe,
    c.equipe_libelle,
    sum(points) as total_points
from v_classement_coureur c
GROUP by  c.equipe, c.equipe_libelle
order by c.equipe, total_points;

*/


create table point_coureur_etape(
    id_point_coureur_etape serial primary key,
    coureur_etape_id int REFERENCES coureur_etape(id_coureur_etape),
    points int default 0
);
create or replace view v_temps_global_coureur as
select
    tc.*,
    ce.coureur_id,ce.etape_id,
    tc.heure_arriver - tc.heure_depart AS duree_parcourt
from temps_coureur_etape tc
right join coureur_etape ce on ce.id_coureur_etape = tc.coureur_etape_id
join etapes e on e.id_etape = ce.etape_id
order by e.rang;


create or replace view v_classement_coureur as
select
    *
from
    v_temps_global_coureur g
    left join
    point_classement p on p.id_point_classement = g.rang_coureur
order by
    etape_id, rang_coureur;
