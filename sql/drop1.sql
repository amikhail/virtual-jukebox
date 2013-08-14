# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases V7.3.5                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          virual_jukebox.dez                              #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database drop script                            #
# Created on:            2013-05-26 18:21                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Drop foreign key constraints                                           #
# ---------------------------------------------------------------------- #

ALTER TABLE `music` DROP FOREIGN KEY `media_music`;

ALTER TABLE `media` DROP FOREIGN KEY `fileType_mediaType_media`;

ALTER TABLE `media` DROP FOREIGN KEY `genre_mediaType_media`;

ALTER TABLE `media` DROP FOREIGN KEY `quality_mediaType_media`;

ALTER TABLE `media` DROP FOREIGN KEY `mediaType_media`;

ALTER TABLE `movie` DROP FOREIGN KEY `media_movie`;

ALTER TABLE `fileType_mediaType` DROP FOREIGN KEY `fileType_fileType_mediaType`;

ALTER TABLE `fileType_mediaType` DROP FOREIGN KEY `mediaType_fileType_mediaType`;

ALTER TABLE `genre_mediaType` DROP FOREIGN KEY `genre_genre_mediaType`;

ALTER TABLE `genre_mediaType` DROP FOREIGN KEY `mediaType_genre_mediaType`;

ALTER TABLE `quality_mediaType` DROP FOREIGN KEY `quality_quality_mediaType`;

ALTER TABLE `quality_mediaType` DROP FOREIGN KEY `mediaType_quality_mediaType`;

# ---------------------------------------------------------------------- #
# Drop table "music"                                                     #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `music` MODIFY `musicId` BIGINT UNSIGNED NOT NULL;

# Drop constraints #

ALTER TABLE `music` DROP PRIMARY KEY;

DROP TABLE `music`;

# ---------------------------------------------------------------------- #
# Drop table "movie"                                                     #
# ---------------------------------------------------------------------- #

# Drop constraints #

ALTER TABLE `movie` DROP PRIMARY KEY;

DROP TABLE `movie`;

# ---------------------------------------------------------------------- #
# Drop table "media"                                                     #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `media` MODIFY `mediaId` BIGINT UNSIGNED NOT NULL;

# Drop constraints #

ALTER TABLE `media` DROP PRIMARY KEY;

DROP TABLE `media`;

# ---------------------------------------------------------------------- #
# Drop table "quality_mediaType"                                         #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `quality_mediaType` MODIFY `quality_mediaType_id` BIGINT UNSIGNED NOT NULL;

# Drop constraints #

ALTER TABLE `quality_mediaType` DROP PRIMARY KEY;

DROP TABLE `quality_mediaType`;

# ---------------------------------------------------------------------- #
# Drop table "genre_mediaType"                                           #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `genre_mediaType` MODIFY `genre_mediaType_id` BIGINT UNSIGNED NOT NULL;

# Drop constraints #

ALTER TABLE `genre_mediaType` DROP PRIMARY KEY;

DROP TABLE `genre_mediaType`;

# ---------------------------------------------------------------------- #
# Drop table "fileType_mediaType"                                        #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `fileType_mediaType` MODIFY `fileType_mediaType_id` BIGINT UNSIGNED NOT NULL;

# Drop constraints #

ALTER TABLE `fileType_mediaType` DROP PRIMARY KEY;

DROP TABLE `fileType_mediaType`;

# ---------------------------------------------------------------------- #
# Drop table "quality"                                                   #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `quality` MODIFY `qualityId` BIGINT UNSIGNED NOT NULL;

# Drop constraints #

ALTER TABLE `quality` DROP PRIMARY KEY;

DROP TABLE `quality`;

# ---------------------------------------------------------------------- #
# Drop table "genre"                                                     #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `genre` MODIFY `genreId` BIGINT UNSIGNED NOT NULL;

# Drop constraints #

ALTER TABLE `genre` DROP PRIMARY KEY;

DROP TABLE `genre`;

# ---------------------------------------------------------------------- #
# Drop table "fileType"                                                  #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `fileType` MODIFY `fileTypeId` BIGINT UNSIGNED NOT NULL;

# Drop constraints #

ALTER TABLE `fileType` DROP PRIMARY KEY;

DROP TABLE `fileType`;

# ---------------------------------------------------------------------- #
# Drop table "mediaType"                                                 #
# ---------------------------------------------------------------------- #

# Remove autoinc for PK drop #

ALTER TABLE `mediaType` MODIFY `mediaTypeId` BIGINT UNSIGNED NOT NULL;

# Drop constraints #

ALTER TABLE `mediaType` DROP PRIMARY KEY;

DROP TABLE `mediaType`;
