/* taxonomy=lex_kliros_quality&tag_ID=639 mixed-chorus */
/*Находим term_id для названия смешанный хор*/
SELECT *
FROM lex_08_19_terms AS terms
WHERE terms.name LIKE 'смеш%'
/*у нас это 639*/

/*Находим term_taxonomy_id для привязки постов к этому термину Состав Хора = Смешанный Хор*/
SELECT *
FROM lex_08_19_term_taxonomy
WHERE term_id=639
/*у нас это 618*/

/*Почистить таблицу term_relationships ID постов с привязкой к этой рубрики иначе не вставится*/
SELECT *
FROM lex_08_19_term_relationships
WHERE term_taxonomy_id=618

/*Вставляем id постов и этот 618 в таблицу связки постов с терминами. Все*/
INSERT INTO 
lex_08_19_term_relationships
	(
	object_id,
	term_taxonomy_id,
	term_order)
SELECT post_id, 618, 0
FROM lex_08_19_postmeta AS meta
WHERE meta.meta_key='quality' and meta.meta_value LIKE 'смеш%'

/*всего сколько песен для смешанного хора*/
SELECT COUNT(*)
FROM lex_08_19_postmeta
WHERE meta_key = 'quality' AND meta_value LIKE 'смеш%'
/*у нас это 1483*/

/*Вписать число песен а таблицу term_taxonomy иначе не видно в админке что песни в рубрике есть, видно только на фронте*/
UPDATE lex_08_19_term_taxonomy 
SET count = 1483
WHERE term_taxonomy_id = 618

/***************************************************************/
/*taxonomy=lex_kliros_quality&tag_ID=640 homogeneous*/
/*Находим term_id для названия однородный хор*/
SELECT *
FROM lex_08_19_terms AS terms
WHERE terms.name LIKE 'однород%'
/*у нас это 640*/

/*Находим term_taxonomy_id для привязки постов к этому термину Состав Хора = Однородный Хор*/
SELECT *
FROM lex_08_19_term_taxonomy
WHERE term_id=640
/*у нас это 619*/

/*Почистить таблицу term_relationships ID постов с привязкой к этой рубрики иначе не вставится*/
SELECT *
FROM lex_08_19_term_relationships
WHERE term_taxonomy_id=619


/*Вставляем id постов и этот 619 в таблицу связки постов с терминами. Все*/
INSERT INTO 
lex_08_19_term_relationships
	(
	object_id,
	term_taxonomy_id,
	term_order)
SELECT post_id, 619, 0
FROM lex_08_19_postmeta AS meta
WHERE meta.meta_key='quality' and meta.meta_value LIKE 'однород%'

/*всего сколько песен для однородного хора*/
SELECT COUNT(*)
FROM lex_08_19_postmeta
WHERE meta_key = 'quality' AND meta_value LIKE 'однород%'
/*у нас это 224*/

/*Вписать число песен а таблицу term_taxonomy иначе не видно в админке что песни в рубрике есть, видно только на фронте*/
UPDATE lex_08_19_term_taxonomy 
SET count =224 
WHERE term_taxonomy_id = 619