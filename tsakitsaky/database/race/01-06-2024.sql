create database race;
\c race;

create table role(
    id_role serial PRIMARY KEY,
    roles varchar(20)
);

insert into role (roles) values
    ('Admin'),
    ('Equipe');

create table utilisateur(
    id_utilisateur serial primary key,
    nom varchar(30) DEFAULT '',
    email varchar(70) DEFAULT '',
    pwd  text DEFAULT ''
);

insert into utilisateur (nom, email, pwd) values
    ('admin', 'admin', 'admin');

create table role_utilisateur(
    id_role_utilsiateur serial primary key,
    role_id int REFERENCES role(id_role),
    utilisateur_id int REFERENCES utilisateur(id_utilisateur)
);


insert into role_utilisateur(role_id, utilisateur_id) values
    (1,1);

create table etapes(
    id_etape serial primary key,
    etape varchar(50) DEFAULT '',
    longueur decimal(20,2) DEFAULT 0,
    nb_coureur int DEFAULT 0,
    rang int default 0,
    date_depart date not null,
    heure_depart time not null
);


create table genre(
    id_genre serial primary key,
    genre varchar(10)
);

insert into genre (genre) values
    ('M'),
    ('F');

create table categorie(
    id_categorie serial primary key,
    categorie varchar(20)
);

insert into categorie(categorie) values
    ('Homme'),
    ('Femme'),
    ('Junior');

create table coureur(
    id_coureur serial primary key,
    nom varchar(30) default '',
    numero_dossard varchar(10) not null ,
    genre_id int REFERENCES genre(id_genre),
    dtn date ,
    equipe int REFERENCES utilisateur(id_utilisateur)
);

create table categorie_coureur(
    id_categorie_coureur serial primary key,
    categorie_id int REFERENCES categorie(id_categorie),
    coureur_id int REFERENCES coureur(id_coureur)
);

create table coureur_etape(
    id_coureur_etape serial primary key,
    etape_id int REFERENCES etapes(id_etape),
    coureur_id int REFERENCES coureur(id_coureur)
);

create table temps_coureur_etape(
    id_temps_coureur_etape serial primary key,
    coureur_etape_id int REFERENCES coureur_etape(id_coureur_etape),
    date_cours date default now(),
    heure_depart time null,
    heure_arriver timestamp null,
    penalite int default 0
);


create table point_classement(
    id_point_classement serial primary key,
    rang int default 0 unique,
    points int default 0
);


create table penalite(
    id_penalite serial primary key,
    etape_id int REFERENCES etapes(id_etape),
    equipe int REFERENCES utilisateur(id_utilisateur),
    penalite time
);
