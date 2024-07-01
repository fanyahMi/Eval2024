create table temp_resultat(
    etape_rang int ,
    numero_dossard  varchar(10),
    nom  varchar(30),
    genre varchar(10),
    date_naissance date,
    equipe varchar(30),
    arrivee TIMESTAMP
);

------utilisateur----
insert into utilisateur (nom, email, pwd)
select
    DISTINCT t.equipe,t.equipe,t.equipe
    from temp_resultat t
    LEFT join  utilisateur  u on u.nom = t.equipe
    WHERE u.nom IS NULL;
-----role utilisateur ----
insert into role_utilisateur (role_id, utilisateur_id)
select
    2,id_utilisateur
    from utilisateur
    left join role_utilisateur
        on role_utilisateur.utilisateur_id = utilisateur.id_utilisateur
    where role_utilisateur.utilisateur_id is null;
 -----genre
 insert into genre (genre)
 select
    DISTINCT temp_resultat.genre
    from temp_resultat
    left join genre on genre.genre = temp_resultat.genre
    WHEre genre.genre is null;
------ coureur
insert into coureur (nom, numero_dossard, genre_id, dtn, equipe)
select
    DISTINCT t.nom,
    t.numero_dossard,
    g.id_genre,
    t.date_naissance,
    u.id_utilisateur
    from temp_resultat t
    left join coureur c on c.nom = t.nom
    join utilisateur u on u.nom = t.equipe
    join genre g on g.genre = t.genre
    where c.nom is null;
 ----- coureur_etap ----
 insert into coureur_etape (etape_id, coureur_id)
 select
    et.id_etape,
    c.id_coureur
    from temp_resultat t
    join coureur c on c.nom = t.nom
    join etapes et on et.rang = t.etape_rang
    left join coureur_etape ct
        on ct.etape_id = et.id_etape and ct.coureur_id = c.id_coureur
    where ct.etape_id is null and  ct.coureur_id is null;

  ----- temps coureur ----
  insert into temps_coureur_etape (coureur_etape_id, date_cours, heure_depart, heure_arriver)
  select
    ct.id_coureur_etape,
    e.date_depart,
    e.heure_depart,
    t.arrivee
    from temp_resultat t
    join etapes e on e.rang =  t.etape_rang
    join coureur c on c.nom = t.nom
    join coureur_etape ct
        on ct.etape_id = e.id_etape and ct.coureur_id = c.id_coureur
    left join
        temps_coureur_etape tc
          on  tc.coureur_etape_id = ct.id_coureur_etape
    where tc.coureur_etape_id is null;





INSERT INTO temp_resultat (etape_rang, numero_dossard, nom, genre, date_naissance, equipe, arrivee) VALUES
(1, '1', 'Tiana', 'F', '1959-10-05', 'B', '2024-06-01 10:01:34'),
(1, '2', 'Faniry', 'F', '1955-07-03', 'A', '2024-06-01 09:54:03'),
(1, '3', 'Zo', 'M', '1963-11-18', 'C', '2024-06-01 09:55:21'),
(1, '4', 'Solo', 'M', '1982-07-07', 'D', '2024-06-01 10:01:34'),
(1, '5', 'Hasina', 'F', '1998-06-11', 'E', '2024-06-01 10:07:29'),
(2, '14', 'Andry', 'M', '1997-09-24', 'A', '2024-06-01 14:02:35'),
(2, '15', 'Koto', 'M', '1983-08-29', 'A', '2024-06-01 14:37:47'),
(2, '6', 'Tina', 'M', '2007-01-04', 'B', '2024-06-01 14:08:12'),
(2, '12', 'Mamy', 'M', '1982-11-29', 'B', '2024-06-01 14:45:23'),
(2, '19', 'Lalao', 'M', '1997-06-21', 'C', '2024-06-01 14:31:58'),
(2, '7', 'Hery', 'M', '1979-04-08', 'C', '2024-06-01 14:15:09'),
(2, '9', 'Rado', 'F', '1990-12-11', 'D', '2024-06-01 14:40:16'),
(2, '18', 'Niry', 'M', '1979-06-01', 'D', '2024-06-01 14:15:09'),
(2, '10', 'Tahina', 'F', '1972-12-20', 'E', '2024-06-01 14:15:09'),
(2, '17', 'Nofy', 'M', '1979-04-20', 'E', '2024-06-01 14:23:11'),
(3, '11', 'Lova', 'F', '1994-09-01', 'A', '2024-06-01 23:45:32'),
(3, '14', 'Andry', 'M', '1997-09-24', 'A', '2024-06-01 23:55:47'),
(3, '15', 'Koto', 'M', '1983-08-29', 'A', '2024-06-01 23:52:11'),
(3, '1', 'Tiana', 'F', '1959-10-05', 'B', '2024-06-02 00:31:23'),
(3, '13', 'Fara', 'M', '2008-01-23', 'B', '2024-06-02 00:04:19'),
(3, '7', 'Hery', 'M', '1979-04-08', 'C', '2024-06-02 00:27:50'),
(3, '8', 'Zara', 'M', '1979-10-16', 'C', '2024-06-02 00:40:08'),
(3, '20', 'Miora', 'F', '1961-08-13', 'C', '2024-06-01 23:47:44'),
(3, '9', 'Rado', 'F', '1990-12-11', 'D', '2024-06-02 00:22:36'),
(3, '16', 'Rina', 'F', '2010-04-23', 'D', '2024-06-01 23:50:18'),
(3, '5', 'Hasina', 'F', '1998-06-11', 'E', '2024-06-02 00:12:09'),
(3, '17', 'Nofy', 'M', '1979-04-20', 'E', '2024-06-01 23:56:53'),
(4, '11', 'Lova', 'F', '1994-09-01', 'A', '2024-06-02 11:13:33'),
(4, '14', 'Andry', 'M', '1997-09-24', 'A', '2024-06-02 11:11:08'),
(4, '6', 'Tina', 'M', '2007-01-04', 'B', '2024-06-02 11:14:55'),
(4, '12', 'Mamy', 'M', '1982-11-29', 'B', '2024-06-02 11:16:29'),
(4, '19', 'Lalao', 'M', '1997-06-21', 'C', '2024-06-02 11:12:46'),
(4, '18', 'Niry', 'M', '1979-06-01', 'D', '2024-06-02 11:20:02'),
(4, '9', 'Rado', 'F', '1990-12-11', 'D', '2024-06-02 11:17:19'),
(4, '5', 'Hasina', 'F', '1998-06-11', 'E', '2024-06-02 11:10:41'),
(4, '10', 'Tahina', 'F', '1972-12-20', 'E', '2024-06-02 11:19:58'),
(5, '2', 'Faniry', 'F', '1955-07-03', 'A', '2024-06-02 13:38:11'),
(5, '6', 'Tina', 'M', '2007-01-04', 'B', '2024-06-02 14:01:23'),
(5, '13', 'Fara', 'M', '2008-01-23', 'B', '2024-06-02 13:26:19'),
(5, '7', 'Hery', 'M', '1979-04-08', 'C', '2024-06-02 13:52:50'),
(5, '8', 'Zara', 'M', '1979-10-16', 'C', '2024-06-02 13:43:08'),
(5, '9', 'Rado', 'F', '1990-12-11', 'D', '2024-06-02 13:20:44'),
(5, '16', 'Rina', 'F', '2010-04-23', 'D', '2024-06-02 13:20:44'),
(5, '17', 'Nofy', 'M', '1979-04-20', 'E', '2024-06-02 13:21:18');


------ equipe ----



----- delete
delete from utilisateur where id_utilisateur != 1;
delete from role_utilisateur where id_role_utilsiateur != 1;
delete from etapes;
delete from coureur;
delete from categorie_coureur;
delete from coureur_etape;
delete from temps_coureur_etape;
delete from point_classement;

