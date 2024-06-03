#
# Table structure for table 'tx_blogexample_domain_model_blog'
#
CREATE TABLE tx_blogexample_domain_model_blog (
	title varchar(255) DEFAULT '' NOT NULL,
	subtitle varchar(255) DEFAULT '',
);

#
# Table structure for table 'tx_blogexample_domain_model_post'
#
CREATE TABLE tx_blogexample_domain_model_post (
	title varchar(255) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'tx_blogexample_domain_model_comment'
#
CREATE TABLE tx_blogexample_domain_model_comment (
	author varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'tx_blogexample_domain_model_person'
#
CREATE TABLE tx_blogexample_domain_model_person (
	firstname varchar(255) DEFAULT '' NOT NULL,
	lastname varchar(255) DEFAULT '' NOT NULL,
	email varchar(255) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'tx_blogexample_domain_model_tag'
#
CREATE TABLE tx_blogexample_domain_model_tag (
	name varchar(255) DEFAULT '' NOT NULL,
);


#
# Table structure for table 'tx_blogexample_domain_model_info'
#
CREATE TABLE tx_blogexample_domain_model_info (
	name varchar(255) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'tx_blogexample_domain_model_tag_mm'
# @TODO fix tx_blogexample_domain_model_person to create and recognize this mm-table
#       with the field `fieldname` automatically, remove this entry
# @see https://forge.typo3.org/issues/98322
#
CREATE TABLE `tx_blogexample_domain_model_tag_mm` (
	`fieldname` varchar(63) DEFAULT '' NOT NULL
);

