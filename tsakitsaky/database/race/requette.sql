SELECT
    id_temps_coureur_etape,
    coureur_etape_id,
    date_cours,
    heure_depart,
    heure_arriver,
    penalite,
    EXTRACT(HOUR FROM (heure_arriver - heure_depart)) AS difference_hours,
    EXTRACT(MINUTE FROM (heure_arriver - heure_depart)) AS difference_minutes,
    EXTRACT(SECOND FROM (heure_arriver - heure_depart)) AS difference_seconds,
     EXTRACT(EPOCH FROM (heure_arriver - heure_depart)) AS difference_seconds_total
FROM
    temps_coureur_etape;


SELECT
    id_temps_coureur_etape,
    coureur_etape_id,
    date_cours,
    heure_depart,
    heure_arriver,
    penalite,
    EXTRACT(EPOCH FROM (heure_arriver - heure_depart)) AS difference_seconds
FROM
    temps_coureur_etape;



select
    g.rang_coureur,
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
    p.points
from
    v_global_temps_coureur g
    join
    point_classement p on p.id_point_classement = g.rang_coureur;



select
    c.equipe,
    c.equipe_libelle,
    sum(points) as total_points
from v_classement_coureur c
GROUP by  c.equipe, c.equipe_libelle
order by c.equipe, total_points;



