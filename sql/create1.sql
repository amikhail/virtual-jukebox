# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases V7.3.5                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          virual_jukebox.dez                              #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2013-05-26 18:21                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Add tables                                                             #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "mediaType"                                                  #
# ---------------------------------------------------------------------- #

CREATE TABLE `mediaType` (
    `mediaTypeId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mediaTypeName` VARCHAR(150) NOT NULL,
    `mediaTypeDisplayLabel` VARCHAR(150) NOT NULL COMMENT 'text for UI',
    `mediaTypeDescription` TEXT,
    CONSTRAINT `PK_mediaType` PRIMARY KEY (`mediaTypeId`)
);

# ---------------------------------------------------------------------- #
# Add table "fileType"                                                   #
# ---------------------------------------------------------------------- #

CREATE TABLE `fileType` (
    `fileTypeId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `fileTypeName` VARCHAR(150) NOT NULL,
    `fileTypeDisplayLabel` VARCHAR(150) NOT NULL COMMENT 'text for UI',
    `fileTypeDescription` TEXT,
    CONSTRAINT `PK_fileType` PRIMARY KEY (`fileTypeId`)
);

# ---------------------------------------------------------------------- #
# Add table "genre"                                                      #
# ---------------------------------------------------------------------- #

CREATE TABLE `genre` (
    `genreId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `genreName` VARCHAR(150) NOT NULL,
    `genreDisplayLabel` VARCHAR(150) NOT NULL COMMENT 'text for UI',
    `genreDescription` TEXT,
    CONSTRAINT `PK_genre` PRIMARY KEY (`genreId`)
);

# ---------------------------------------------------------------------- #
# Add table "quality"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `quality` (
    `qualityId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `qualityName` VARCHAR(150) NOT NULL,
    `qualityDisplayLabel` VARCHAR(150) NOT NULL COMMENT 'text for UI',
    `qualityDescription` TEXT,
    CONSTRAINT `PK_quality` PRIMARY KEY (`qualityId`)
);

# ---------------------------------------------------------------------- #
# Add table "fileType_mediaType"                                         #
# ---------------------------------------------------------------------- #

CREATE TABLE `fileType_mediaType` (
    `fileType_mediaType_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mediaTypeId` BIGINT UNSIGNED NOT NULL,
    `fileTypeId` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `PK_fileType_mediaType` PRIMARY KEY (`fileType_mediaType_id`)
);

# ---------------------------------------------------------------------- #
# Add table "genre_mediaType"                                            #
# ---------------------------------------------------------------------- #

CREATE TABLE `genre_mediaType` (
    `genre_mediaType_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mediaTypeId` BIGINT UNSIGNED NOT NULL,
    `genreId` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `PK_genre_mediaType` PRIMARY KEY (`genre_mediaType_id`)
);

# ---------------------------------------------------------------------- #
# Add table "quality_mediaType"                                          #
# ---------------------------------------------------------------------- #

CREATE TABLE `quality_mediaType` (
    `quality_mediaType_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mediaTypeId` BIGINT UNSIGNED NOT NULL,
    `qualityId` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `PK_quality_mediaType` PRIMARY KEY (`quality_mediaType_id`)
);

# ---------------------------------------------------------------------- #
# Add table "media"                                                      #
# ---------------------------------------------------------------------- #

CREATE TABLE `media` (
    `mediaId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mediaTypeId` BIGINT UNSIGNED NOT NULL,
    `filePath` VARCHAR(300),
    `fileSize` BIGINT UNSIGNED,
    `playLength` BIGINT UNSIGNED,
    `fileType_mediaType_id` BIGINT UNSIGNED,
    `genre_mediaType_id` BIGINT UNSIGNED,
    `quality_mediaType_id` BIGINT UNSIGNED,
    CONSTRAINT `PK_media` PRIMARY KEY (`mediaId`)
);

# ---------------------------------------------------------------------- #
# Add table "movie"                                                      #
# ---------------------------------------------------------------------- #

CREATE TABLE `movie` (
    `mediaId` BIGINT UNSIGNED NOT NULL,
    CONSTRAINT `PK_movie` PRIMARY KEY (`mediaId`)
);

# ---------------------------------------------------------------------- #
# Add table "music"                                                      #
# ---------------------------------------------------------------------- #

CREATE TABLE `music` (
    `musicId` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mediaId` BIGINT UNSIGNED NOT NULL,
    `songTitle` VARCHAR(200) NOT NULL,
    `albumTitle` VARCHAR(200),
    `artist` VARCHAR(200),
	`year` VARCHAR(10),
    CONSTRAINT `PK_music` PRIMARY KEY (`musicId`, `mediaId`)
);

# ---------------------------------------------------------------------- #
# Add foreign key constraints                                            #
# ---------------------------------------------------------------------- #

ALTER TABLE `music` ADD CONSTRAINT `media_music` 
    FOREIGN KEY (`mediaId`) REFERENCES `media` (`mediaId`);

ALTER TABLE `media` ADD CONSTRAINT `fileType_mediaType_media` 
    FOREIGN KEY (`fileType_mediaType_id`) REFERENCES `fileType_mediaType` (`fileType_mediaType_id`);

ALTER TABLE `media` ADD CONSTRAINT `genre_mediaType_media` 
    FOREIGN KEY (`genre_mediaType_id`) REFERENCES `genre_mediaType` (`genre_mediaType_id`);

ALTER TABLE `media` ADD CONSTRAINT `quality_mediaType_media` 
    FOREIGN KEY (`quality_mediaType_id`) REFERENCES `quality_mediaType` (`quality_mediaType_id`);

ALTER TABLE `media` ADD CONSTRAINT `mediaType_media` 
    FOREIGN KEY (`mediaTypeId`) REFERENCES `mediaType` (`mediaTypeId`);

ALTER TABLE `movie` ADD CONSTRAINT `media_movie` 
    FOREIGN KEY (`mediaId`) REFERENCES `media` (`mediaId`);

ALTER TABLE `fileType_mediaType` ADD CONSTRAINT `fileType_fileType_mediaType` 
    FOREIGN KEY (`fileTypeId`) REFERENCES `fileType` (`fileTypeId`);

ALTER TABLE `fileType_mediaType` ADD CONSTRAINT `mediaType_fileType_mediaType` 
    FOREIGN KEY (`mediaTypeId`) REFERENCES `mediaType` (`mediaTypeId`);

ALTER TABLE `genre_mediaType` ADD CONSTRAINT `genre_genre_mediaType` 
    FOREIGN KEY (`genreId`) REFERENCES `genre` (`genreId`);

ALTER TABLE `genre_mediaType` ADD CONSTRAINT `mediaType_genre_mediaType` 
    FOREIGN KEY (`mediaTypeId`) REFERENCES `mediaType` (`mediaTypeId`);

ALTER TABLE `quality_mediaType` ADD CONSTRAINT `quality_quality_mediaType` 
    FOREIGN KEY (`qualityId`) REFERENCES `quality` (`qualityId`);

ALTER TABLE `quality_mediaType` ADD CONSTRAINT `mediaType_quality_mediaType` 
    FOREIGN KEY (`mediaTypeId`) REFERENCES `mediaType` (`mediaTypeId`);
