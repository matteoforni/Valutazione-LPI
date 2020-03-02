/*  
CREAZIONE DEL DATABASE
*/
drop database valutazionelpi;
create database valutazionelpi;
use valutazionelpi;
create table role(
	id int primary key auto_increment,
    name varchar(100) not null
);
create table user(
	id int primary key auto_increment,
    name varchar(100) not null,
    surname varchar(100) not null,
    email varchar(100) not null unique,
    phone varchar(50) not null unique,
    password varchar(255) not null,
    confirmed tinyint(1) not null,
    id_role int,
    first_login tinyint(1) not null,
    reset_token varchar(100),
    confirmation_token varchar(100),
    foreign key(id_role) references role(id) on delete set null
);
create table point(
	code varchar(10) primary key,
    title varchar(255) not null,
    description longtext,
    type tinyint(1) not null
);
create table justification(
	id int primary key auto_increment,
    text longtext not null,
    id_point varchar(10) not null,
    foreign key(id_point) references point(code) on delete cascade
);
create table form(
	id int primary key auto_increment,
    title varchar(255) not null,
    created datetime not null,
    modified datetime,
    deleted datetime,
    student_name varchar(100) not null,
    student_surname varchar(100) not null,
    student_email varchar(100) not null,
    student_phone varchar(50) not null,
    teacher_name varchar(100) not null,
    teacher_surname varchar(100) not null,
    teacher_email varchar(100) not null,
    teacher_phone varchar(50) not null,
    expert1_name varchar(100),
    expert1_surname varchar(100),
    expert1_email varchar(100),
    expert1_phone varchar(50),
    expert2_name varchar(100),
    expert2_surname varchar(100),
    expert2_email varchar(100),
    expert2_phone varchar(50),
    id_user int,
    foreign key(id_user) references user(id) on delete set null
);
create table contains(
	id_justification int,
    id_form int,
    primary key(id_justification, id_form),
    foreign key(id_justification) references justification(id),
    foreign key(id_form) references form(id)
);

/*
CREAZIONE DELL'UTENTE UTILIZZATO DAL PROGRAMMA
*/
create user 'valutazionelpi'@'localhost' identified by 'ValutazioneLPI&2020';
GRANT SELECT, INSERT, UPDATE, DELETE ON valutazionelpi.* TO 'valutazionelpi'@'localhost';
flush privileges;

/*
INSERIMENTO DEI RUOLI
*/
insert into role(name) values ("teacher");
insert into role(name) values ("admin");

/*
INSERIMENTO PUNTI 
*/
insert into point(code, title, description, type) values ("A1", "Gestione del progetto e pianificazione", "Attraverso la gestione di progetti è possibile risolvere compiti complessi, in particolare suddividendolo in piccole parti. Anche per i lavori pratici, è bene analizzare le relazioni, pianificare i vari compiti e mettere a confronto le varianti ed elaborare un piano d’azione.", 0);
insert into point(code, title, description, type) values ("A2", "Acquisizione del sapere", "Le informazioni a disposizione sono molteplici e svariate. Il candidato/a può selezionare i supporti e i canali d’informazioni in funzione del compito da svolgere e sfruttarli conformemente allo scopo ricercato.", 0);
insert into point(code, title, description, type) values ("B1", "Riassunto del rapporto del LPI/versione concisa della documentazione.", "Un riassunto concettuale del lavoro effettuato e del risultato ottenuto permette ai lettori coinvolti nel progetto (superiore, esperti) di capire meglio il lavoro fornito. La versione concisa non contiene grafiche, ma solo testo (Abstract).", 0);
insert into point(code, title, description, type) values ("B2", "Svolgimento del diario di lavoro.", "Il diario di lavoro serve a documentare le attività quotidiane, i problemi incontrati e gli eventuali lavori imprevisti, aiuti e ore supplementari. È chiaramente strutturato e si riferisce al piano di progetto.", 0);
insert into point(code, title, description, type) values ("C1", "Gestione del tempo, struttura", "La struttura e il contenuto della presentazione si limitano ai principali aspetti del LPI (compito, svolgimento, risultati). Il tempo concesso per la presentazione deve essere rispettato.", 0);
insert into point(code, title, description, type) values ("C2", "Presentazione: utilizzo dei media, aspetti tecnici", "La presentazione e la dimostrazione del progetto è supporatta dastrumenti tecnici (da soli o in combinazione). Il o la candidato/a deve saperli utilizzare correttamente e in modo adeguato.", 0);

insert into point(code, title, description, type) values ("159", "Analisi del problema (programmazione)", "Il o la candidato/a è capace di analizzare il problema?", 1);
insert into point(code, title, description, type) values ("162", "Progettazione (Architettura del programma)", "Il concetto segue le attuali regole dell’architettura software correnti o è modularizzato/strutturato?", 1);
insert into point(code, title, description, type) values ("165", "Implementazione della soluzione (programmazione)", "Il candidato è in grado d’implementare le soluzioni proposte?", 1);
insert into point(code, title, description, type) values ("121", "Ergonomia del programma (programmazione)", "L'applicazione è facile da usare (user-friendly)? L'ergonomia richiesta dall'utente è implementata?", 1);
insert into point(code, title, description, type) values ("166", "Stile di codifica e leggibilità del codice", "Il codice è scritto in modo leggibile, ben organizzato e la nomenclatura è stata scelta opportunamente?", 1);
insert into point(code, title, description, type) values ("164", "Codifica: Trattamento degli errori", "Gestione degli errori: gli eventuali errori sono identificati e gestiti tramite i mezzi adeguati?", 1);
insert into point(code, title, description, type) values ("128", "Identificazione delle entità necessarie conformemente al problema dato", "È disponibile un modello E-R (entità-relazione) che permette di rappresentare il il problema per comprenderlo facilmente?", 1);
insert into point(code, title, description, type) values ("135", "Documentazione DB e tabelle", "Il database è sufficientemente documentato, cioè vengono descritte le funzioni, le transazioni, le definizioni delle tabelle, le relazioni e le strategie di accesso.", 1);

/*
INSERIMENTO DELLE MOTIVAZIONI DI TEST
*/
insert into justification(text, id_point) values ("Attività del Gantt non rispettate", "A1");
insert into justification(text, id_point) values ("Il Gantt non mostra le ore di lavoro", "A1");
insert into justification(text, id_point) values ("Descritto con poca precisione e sommariamente", "B1");
insert into justification(text, id_point) values ("Diario consegnato in ritardo", "B2");
insert into justification(text, id_point) values ("Presentazione durata troppo poco", "C1");
insert into justification(text, id_point) values ("Errori con il funzionamento di Powerpoint", "C2");

/*
INSERIMENTO DEI FORMULARI DI TEST
*/
insert into form(title, created, modified, deleted, student_name, student_surname, student_email, student_phone, teacher_name, teacher_surname, teacher_email, teacher_phone, id_user)
 values ("Gestione grotti", "10.11.2019", "20.12.2019", null, "Matteo", "Forni", "matteo.forni@samtrevano.ch", "0799119368", "Luca", "Peduzzi", "luca.peduzzi@edu.ti.ch", "0790123456", 1);

select * from point;
select * from user;
update user set id_role=2 where id = 1;
