create or replace view v_categorie_id_coureur as
select
    *
from categorie_coureur cc
join categorie c on c.id_categorie = cc.categorie_id;

create or replace view v_somme_penalite as
select
etape_id,equipe,SUM(penalite)::TIME as penalite
from penalite
group by etape_id,equipe;

create or replace view v_temps_global_coureur as
SELECT
    DENSE_RANK() OVER (PARTITION BY c.etape_id, cv.categorie ORDER BY t.date_cours,  (COALESCE(EXTRACT(EPOCH from((t.heure_arriver+COALESCE(p.penalite,'00:00:00')) - (t.date_cours + t.heure_depart))),0))) AS rang_coureur,
    DENSE_RANK() OVER (PARTITION BY c.etape_id ORDER BY t.date_cours,  (COALESCE(EXTRACT(EPOCH from((t.heure_arriver+COALESCE(p.penalite,'00:00:00')) - (t.date_cours + t.heure_depart))),0))) AS rang_coureur2,
    t.id_temps_coureur_etape,
    COALESCE(t.coureur_etape_id, id_coureur_etape) AS coureur_etape_id,
    c.etape_id,
    et.etape,
    et.nb_coureur,
    et.rang,
    cr.equipe,
    eq.nom AS equipe_libelle,
    c.coureur_id,
    cr.nom,
    g.id_genre,
    g.genre,
    cv.id_categorie,
    cv.categorie,
    COALESCE(t.date_cours, NULL) AS date_cours,
    COALESCE(t.heure_depart, NULL) AS heure_depart,
    COALESCE(t.heure_arriver, NULL) AS heure_arriver,
    COALESCE(EXTRACT(DAY FROM (t.heure_arriver - (t.date_cours + t.heure_depart))), 0) AS difference_days,
    COALESCE(EXTRACT(HOUR FROM (t.heure_arriver - (t.date_cours + t.heure_depart))), 0) AS difference_hours,
    COALESCE(EXTRACT(MINUTE FROM (t.heure_arriver - (t.date_cours + t.heure_depart))), 0) AS difference_minutes,
    COALESCE(EXTRACT(SECOND FROM (t.heure_arriver - (t.date_cours + t.heure_depart))), 0) AS difference_seconds,
    COALESCE(EXTRACT(EPOCH FROM (t.heure_arriver - (t.date_cours + t.heure_depart))), 0) AS difference_seconds_total,
    (t.heure_arriver - (t.date_cours + t.heure_depart)) AS temps_chrono,
    COALESCE(p.penalite,'00:00:00') as penalite,
    (COALESCE(EXTRACT(EPOCH from((t.heure_arriver+COALESCE(p.penalite,'00:00:00')) - (t.date_cours + t.heure_depart))),0)) as difference_seconds_penalite,
    ((t.heure_arriver+COALESCE(p.penalite,'00:00:00')) - (t.date_cours + t.heure_depart)) AS temps_chrono_penalite

FROM
    temps_coureur_etape t
RIGHT JOIN
    coureur_etape c ON c.id_coureur_etape = t.coureur_etape_id
JOIN
    coureur cr ON cr.id_coureur = c.coureur_id
    Join genre g on g.id_genre = cr.genre_id
JOIN
    v_categorie_id_coureur cv ON cv.coureur_id = cr.id_coureur
JOIN
    utilisateur eq ON eq.id_utilisateur = cr.equipe
JOIN
    etapes et ON et.id_etape = c.etape_id
left join
    v_somme_penalite p on p.etape_id = c.etape_id and p.equipe = cr.equipe
ORDER BY
    et.rang, cv.categorie, t.date_cours, difference_seconds_total ASC;

create or replace view v_global_temps_coureur_simple as
SELECT
    DENSE_RANK() OVER (PARTITION BY c.etape_id ORDER BY t.date_cours,  (COALESCE(EXTRACT(EPOCH from((t.heure_arriver+COALESCE(p.penalite,'00:00:00')) - (t.date_cours + t.heure_depart))),0))) AS rang_coureur2,
    t.id_temps_coureur_etape,
    COALESCE(t.coureur_etape_id, id_coureur_etape) AS coureur_etape_id,
    c.etape_id,
    et.etape,
    et.nb_coureur,
    et.rang,
    cr.equipe,
    eq.nom AS equipe_libelle,
    c.coureur_id,
    cr.nom,
    g.id_genre,
    g.genre,
    COALESCE(t.date_cours, NULL) AS date_cours,
    COALESCE(t.heure_depart, NULL) AS heure_depart,
    COALESCE(t.heure_arriver, NULL) AS heure_arriver,
    COALESCE(EXTRACT(DAY FROM (t.heure_arriver - (t.date_cours + t.heure_depart))), 0) AS difference_days,
    COALESCE(EXTRACT(HOUR FROM (t.heure_arriver - (t.date_cours + t.heure_depart))), 0) AS difference_hours,
    COALESCE(EXTRACT(MINUTE FROM (t.heure_arriver - (t.date_cours + t.heure_depart))), 0) AS difference_minutes,
    COALESCE(EXTRACT(SECOND FROM (t.heure_arriver - (t.date_cours + t.heure_depart))), 0) AS difference_seconds,
    COALESCE(EXTRACT(EPOCH FROM (t.heure_arriver - (t.date_cours + t.heure_depart))), 0) AS difference_seconds_total,
    (t.heure_arriver - (t.date_cours + t.heure_depart)) AS temps_chrono,
    COALESCE(p.penalite,'00:00:00') as penalite,
    (COALESCE(EXTRACT(EPOCH from((t.heure_arriver+COALESCE(p.penalite,'00:00:00')) - (t.date_cours + t.heure_depart))),0)) as difference_seconds_penalite,
    ((t.heure_arriver+COALESCE(p.penalite,'00:00:00')) - (t.date_cours + t.heure_depart)) AS temps_chrono_penalite

FROM
    temps_coureur_etape t
RIGHT JOIN
    coureur_etape c ON c.id_coureur_etape = t.coureur_etape_id
JOIN
    coureur cr ON cr.id_coureur = c.coureur_id
    Join genre g on g.id_genre = cr.genre_id
JOIN
    utilisateur eq ON eq.id_utilisateur = cr.equipe
JOIN
    etapes et ON et.id_etape = c.etape_id
left join
    v_somme_penalite p on p.etape_id = c.etape_id and p.equipe = cr.equipe
ORDER BY
    et.rang,  t.date_cours, difference_seconds_total ASC;


create or replace view v_classement_coureur as
select
    g.rang_coureur,
    g.rang_coureur2,
    g.coureur_etape_id,
    g.etape_id,
    g.etape,
    g.equipe,
    g.equipe_libelle,
    g.nom,
    g.genre,
    g.categorie,
    g.id_categorie,
case
        when g.heure_arriver is null then 0
        else coalesce(p.points, 0)
    end as points,
 g.difference_seconds_total,
    g.date_cours,
    g.heure_depart,
    g.heure_arriver,
    g.penalite,
    g.difference_hours,
    g.difference_minutes,
    g.difference_seconds,
    g.temps_chrono,
    coalesce(g.temps_chrono_penalite,g.temps_chrono) as temps_chrono_penalite
from
    v_temps_global_coureur g
    left join
    point_classement p on p.rang = g.rang_coureur
order by
    etape_id, categorie,rang_coureur;


create or replace view v_classement_coureur_simple as
select
    g.rang_coureur2,
    g.coureur_etape_id,
    g.etape_id,
    g.etape,
    g.equipe,
    g.equipe_libelle,
    g.nom,
    g.genre,
case
        when g.heure_arriver is null then 0
        else coalesce(p.points, 0)
    end as points,
 g.difference_seconds_total,
    g.date_cours,
    g.heure_depart,
    g.heure_arriver,
    g.penalite,
    g.difference_hours,
    g.difference_minutes,
    g.difference_seconds,
    g.temps_chrono,
    coalesce(g.temps_chrono_penalite,g.temps_chrono) as temps_chrono_penalite
from
    v_global_temps_coureur_simple g
    left join
    point_classement p on p.rang = g.rang_coureur2
order by
    etape_id,rang_coureur2;



create or replace view v_liste_coureur_sans_duree_etape as
select
    coureur_etape_id,
    nom,
    etape,
    etape_id
    from v_classement_coureur
    where difference_seconds_total = 0
group by coureur_etape_id,nom,etape,etape_id;

create or replace view v_classement_equipe_simple as
select
    c.equipe,
    c.equipe_libelle,
    sum(points) as total_points
from v_classement_coureur_simple c
GROUP by  c.equipe, c.equipe_libelle
order by c.equipe, total_points;

create or replace view v_total_penalite as
select
    equipe,sum(penalite) as total_penalite
from penalite
group by equipe
;

create or replace view v_classement_categorie as
select
    vc.equipe, equipe_libelle,
    id_categorie, categorie,
    sum(difference_seconds_total) as total_heure,
    sum(points) as points,
    sum(temps_chrono) as temps_chrono
from v_classement_coureur vc
left join v_total_penalite v on v.equipe = vc.equipe
group by vc.equipe, equipe_libelle, id_categorie, categorie
order by points desc ,categorie;
