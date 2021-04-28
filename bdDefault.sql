/**
 * Powered By EndMove / Jérémi Nihart
 * Version : 1.0
 */

-- Table Compte
CREATE TABLE IF NOT EXISTS compte (
  id_compte INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nom VARCHAR(45) NOT NULL,
  prenom VARCHAR(45) NOT NULL,
  login VARCHAR(35) NOT NULL,
  couriel VARCHAR(255) NOT NULL,
  mot_de_passe VARCHAR(255) NOT NULL,
  est_bloque BOOLEAN NOT NULL DEFAULT false,
  est_admin BOOLEAN NOT NULL DEFAULT false,
  PRIMARY KEY (id_compte)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table Chaine
CREATE TABLE IF NOT EXISTS chaine (
  id_chaine INT UNSIGNED NOT NULL AUTO_INCREMENT,
  fk_compte INT UNSIGNED NOT NULL,
  nom VARCHAR(155) NOT NULL DEFAULT 'no name',
  est_publique BOOLEAN NOT NULL DEFAULT true,
  evaluation INT NOT NULL,
  date_derniere_video DATETIME,
  est_bloquee BOOLEAN NOT NULL DEFAULT false,
  PRIMARY KEY (id_chaine),
  FOREIGN KEY (fk_compte) REFERENCES compte (id_compte) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table Video
CREATE TABLE IF NOT EXISTS video (
  id_video INT UNSIGNED NOT NULL AUTO_INCREMENT,
  fk_chaine INT UNSIGNED NOT NULL,
  intitule VARCHAR(155) NOT NULL DEFAULT 'no title',
  description TEXT,
  html_fragment TEXT,
  duree TIME NOT NULL DEFAULT '00:00:00',
  url_apercu varchar(255),
  date_ajout DATETIME NOT NULL,
  est_bloquee BOOLEAN NOT NULL DEFAULT false,
  PRIMARY KEY (id_video),
  FOREIGN KEY (fk_chaine) REFERENCES chaine (id_chaine) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table Commentaire
CREATE TABLE IF NOT EXISTS commentaire (
  id_commentaire INT UNSIGNED NOT NULL AUTO_INCREMENT,
  fk_compte INT UNSIGNED NOT NULL,
  fk_video INT UNSIGNED NOT NULL,
  commentaire TEXT,
  date_publication DATETIME NOT NULL,
  PRIMARY KEY (id_commentaire),
  FOREIGN KEY (fk_compte) REFERENCES compte (id_compte) ON DELETE CASCADE,
  FOREIGN KEY (fk_video) REFERENCES video (id_video) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table Demande
CREATE TABLE IF NOT EXISTS demande (
  id_compte_demandeur INT UNSIGNED NOT NULL,
  id_compte_destinataire INT UNSIGNED NOT NULL,
  est_acceptee BOOLEAN NOT NULL DEFAULT false,
  PRIMARY KEY (id_compte_demandeur, id_compte_destinataire),
  FOREIGN KEY (id_compte_demandeur) REFERENCES compte (id_compte) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table Voir
CREATE TABLE IF NOT EXISTS voir (
  id_compte INT UNSIGNED NOT NULL,
  id_video INT UNSIGNED NOT NULL,
  date_vue DATETIME NOT NULL,
  PRIMARY KEY (id_compte, id_video),
  FOREIGN KEY (id_compte) REFERENCES compte (id_compte),
  FOREIGN KEY (id_video) REFERENCES video (id_video) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table Evaluer
CREATE TABLE IF NOT EXISTS evaluer (
  id_compte INT UNSIGNED NOT NULL,
  id_video INT UNSIGNED NOT NULL,
  evaluation INT NOT NULL,
  PRIMARY KEY (id_compte, id_video),
  FOREIGN KEY (id_compte) REFERENCES compte (id_compte),
  FOREIGN KEY (id_video) REFERENCES video (id_video) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;