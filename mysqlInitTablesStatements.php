<?php

return [
	"requiredStatement" => [
		"create database if not exists TAL_Project_BDD;",

		"use TAL_Project_BDD;",

		"create table if not exists TALBDD_Action
		(
			id int auto_increment primary key,
			code varchar(20) not null,
			description varchar(255) not null,
			constraint TALBDD_Action_code_uindex unique (code)
		);",

		"create table if not exists TALBDD_BanWord
		(
			id int auto_increment primary key,
			message text null,
			creationDate date null,
			updateDate date null
		);",

		"create table if not exists TALBDD_DonationTier
		(
			id int auto_increment primary key,
			name varchar(20) not null,
			description text null,
			price int not null,
			constraint table_name_id_uindex unique (id),
			constraint table_name_price_uindex unique (price)
		);",

		"create table if not exists TALBDD_Role
		(
			id int auto_increment primary key,
			name varchar(40) not null,
			description text not null,
			constraint TALBDD_Role_name_uindex unique (name)
		);",

		"create table if not exists TALBDD_Permission
		(
			id int auto_increment primary key,
			idRole int not null,
			idAction int not null,
			constraint TALBDD_Permission_TALBDD_ACTION_idAction_fk foreign key (idAction) references TALBDD_Action (id),
			constraint TALBDD_Permission_TALBDD_ROLE_idRole_fk foreign key (idRole) references TALBDD_Role (id)
		);",

		"create table if not exists TALBDD_Tag
		(
			id int auto_increment primary key,
			name varchar(20) not null,
			description text null,
			constraint TALBADD_Tag_id_uindex unique (id),
			constraint TALBADD_Tag_name_uindex unique (name)
		);",

		"create table if not exists TALBDD_TotalVisitor
		(
			id int auto_increment primary key,
			session text not null,
			time int not null
		);",

		"create table if not exists TALBDD_User
		(
			id int auto_increment primary key,
			idRole int not null,
			avatar longblob null,
			firstname varchar(60) not null,
			lastname varchar(60) not null,
			email varchar(320) null,
			password varchar(255) not null,
			token varchar(255) not null,
			creationDate date not null,
			verifyAccount binary(1) default 0x30 null,
			activeAccount binary(1) default 0x31 null,
			constraint TALBDD_User_email_uindex unique (email),
			constraint TALBDD_User_TALBDD_ROLE_idRole_fk foreign key (idRole) references TALBDD_Role (id)
		);",

		"create table if not exists TALBDD_Article
		(
			id int auto_increment primary key,
			idUser int not null,
			title varchar(60) not null,
			creationDate date not null,
			constraint TALBDD_Article_title_uindex unique (title),
			constraint TALBDD_Article_TALBDD_User_idUser_fk foreign key (idUser) references TALBDD_User (id)
		);",

		"create table if not exists TALBDD_Donation
		(
			id int auto_increment primary key,
			idUser int not null,
			amount int not null,
			date date not null,
			constraint TALBDD_Donation_TALBDD_User_idUser_fk foreign key (idUser) references TALBDD_User (id)
		);",

		"create table if not exists TALBDD_Forum
		(
			id int auto_increment primary key,
			idUser int not null,
			idTag int not null,
			title varchar(255) not null,
			content text not null,
			creationDate date not null,
			updateDate date not null,
			constraint TALBDD_Forum_TALBDD_Tag_idTag_fk foreign key (idTag) references TALBDD_Tag (id),
			constraint TALBDD_Forum_TALBDD_User_idUser_fk foreign key (idUser) references TALBDD_User (id)
		);",

		"create table if not exists TALBDD_Image
		(
			id int auto_increment primary key,
			idArticle int not null,
			content blob not null,
			constraint TALBDD_Image_TALBDD_Article_idArticle_fk foreign key (idArticle) references TALBDD_Article (id)
		);",

		"create table if not exists TALBDD_Log
		(
			id int auto_increment primary key,
			idUser int not null,
			action varchar(255) not null,
			time int not null,
			constraint TALBDD_Log_TALBDD_User_idUser_fk foreign key (idUser) references TALBDD_User (id)
		);",

		"create table if not exists TALBDD_Message
		(
			id int auto_increment primary key,
			idUser int not null,
			idForum int not null,
			idMessage int null,
			content text not null,
			creationDate datetime not null,
			updateDate datetime not null,
			constraint TALBDD_Message_TALBDD_Forum_idForum_fk foreign key (idForum) references TALBDD_Forum (id),
			constraint TALBDD_Message_TALBDD_USER_idUser_fk foreign key (idUser) references TALBDD_User (id)
		);",

		"create table if not exists TALBDD_Page
		(
			id int auto_increment primary key,
			idUser int not null,
			uri varchar(255) not null,
			description varchar(255) not null,
			content text not null,
			dateModification datetime not null,
			constraint FK_PAGE_USER foreign key (idUser) references TALBDD_User (id)
		);",

		"create table if not exists TALBDD_Rate
		(
			id int auto_increment primary key,
			idUser int not null,
			rate int not null,
			description varchar(255) null,
			creationDate datetime not null,
			updateDate datetime not null,
			constraint table_name_id_uindex unique (id),
			constraint table_name_TALBDD_User_id_fk foreign key (idUser) references TALBDD_User (id)
		);",

		"create table if not exists TALBDD_Video
		(
			id int auto_increment primary key,
			idArticle int not null,
			link varchar(255) null,
			constraint TALBDD_Video_TALBDD_Article_idArticle_fk foreign key (idArticle) references TALBDD_Article (id)
		);",

		"create table if not exists TALBDD_Warning
		(
			id int auto_increment primary key,
			idMessage int not null,
			idUser int not null,
			status int not null,
			creationDate datetime not null,
			updateDate datetime not null,
			constraint TALBDD_Warning_idMessage_uindex unique (idMessage),
			constraint TALBDD_Warning_TALBDD_Message_id_fk foreign key (idMessage) references TALBDD_Message (id),
			constraint TALBDD_Warning_TALBDD_User_id_fk foreign key (idUser) references TALBDD_User (id)
		);",

		"INSERT INTO TAL_Project_BDD.TALBDD_Action (id, code, description) VALUES (1, 'MANAGE_USER', 'Gestion des utilisateurs');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Action (id, code, description) VALUES (2, 'MANAGE_ROLE', 'Gestion des rôles');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Action (id, code, description) VALUES (3, 'MANAGE_PAGE', 'Gestion des pages');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Action (id, code, description) VALUES (4, 'ADMIN_ACCESS', 'Accès au tableau de bord');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Action (id, code, description) VALUES (5, 'MANAGE_DONATION_TIER', 'Gestion des paliers de donation');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Action (id, code, description) VALUES (6, 'MANAGE_FORUM', 'Gestion des articles et des catégories d''articles');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Action (id, code, description) VALUES (7, 'MANAGE_TEMPLATE', 'Gestion des templates');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Role (id, name, description) VALUES (1, 'Administrateur', 'Tout les droits');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Role (id, name, description) VALUES (2, 'Utilisateur', 'Aucun droit');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Permission (id, idRole, idAction) VALUES (1, 1, 1);",

		"INSERT INTO TAL_Project_BDD.TALBDD_Permission (id, idRole, idAction) VALUES (2, 1, 2);",

		"INSERT INTO TAL_Project_BDD.TALBDD_Permission (id, idRole, idAction) VALUES (3, 1, 3);",

		"INSERT INTO TAL_Project_BDD.TALBDD_Permission (id, idRole, idAction) VALUES (4, 1, 4);",

		"INSERT INTO TAL_Project_BDD.TALBDD_Permission (id, idRole, idAction) VALUES (5, 1, 5);",

		"INSERT INTO TAL_Project_BDD.TALBDD_Permission (id, idRole, idAction) VALUES (6, 1, 6);",

		"INSERT INTO TAL_Project_BDD.TALBDD_Permission (id, idRole, idAction) VALUES (7, 1, 7);"
	],

	"finalizationStatement" => [
		"INSERT INTO TAL_Project_BDD.TALBDD_Page (idUser, uri, description, content, dateModification) VALUES (1, '/home', 'Page d''accueil', '', '".date("Y-m-d")."');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Page (idUser, uri, description, content, dateModification) VALUES (1, '/presentation', 'Une page de présentation du jeu', '', '".date("Y-m-d")."');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Page (idUser, uri, description, content, dateModification) VALUES (1, '/galerie', 'Une page présentant les différents scènes de jeu', '', '".date("Y-m-d")."');",

		"INSERT INTO TAL_Project_BDD.TALBDD_Page (idUser, uri, description, content, dateModification) VALUES (1, '/faq', 'Une page question/réponse les plus solicités', '', '".date("Y-m-d")."');"
	]
];