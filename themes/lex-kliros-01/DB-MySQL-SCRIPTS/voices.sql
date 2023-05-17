/* taxonomy=lex_kliros_voices&tag_ID=641 quadro */
/*Находим term_id для названия квартет*/
SELECT *
FROM lex_08_19_terms AS terms
WHERE terms.name LIKE 'квартет%'
/*у нас это 641*/


/*Находим term_taxonomy_id для привязки постов к этому термину Квартет/Трио = Квартет и более*/
SELECT *
FROM lex_08_19_term_taxonomy
WHERE term_id=641
/*у нас это 620*/

/*Почистить таблицу term_relationships ID постов с привязкой к этой рубрики иначе не вставится*/
SELECT *
FROM lex_08_19_term_relationships
WHERE term_taxonomy_id=620

/*Вставляем id постов и этот 620 в таблицу связки постов с терминами. Все*/
INSERT INTO 
lex_08_19_term_relationships
	(
	object_id,
	term_taxonomy_id,
	term_order)
SELECT post_id, 620, 0
FROM lex_08_19_postmeta AS meta
WHERE meta.meta_key='voices' and meta.meta_value LIKE 'квартет%'

/*всего сколько песен для квартета*/
SELECT COUNT(*)
FROM lex_08_19_postmeta
WHERE meta_key = 'voices' AND meta_value LIKE 'квартет%'
/*у нас это 1640*/

/*Вписать число песен а таблицу term_taxonomy иначе не видно в админке что песни в рубрике есть, видно только на фронте*/
UPDATE lex_08_19_term_taxonomy 
SET count = 1640
WHERE term_taxonomy_id = 620


/***************************************************************/
/* taxonomy=lex_kliros_voices&tag_ID=642 trio */
/*Находим term_id для названия трио*/
SELECT *
FROM lex_08_19_terms AS terms
WHERE terms.name LIKE 'трио%'
/*у нас это 642*/

/*Находим term_taxonomy_id для привязки постов к этому термину Квартет/Трио = трио*/
SELECT *
FROM lex_08_19_term_taxonomy
WHERE term_id=642
/*у нас это 621*/

/*Почистить таблицу term_relationships ID постов с привязкой к этой рубрики иначе не вставится*/
SELECT *
FROM lex_08_19_term_relationships
WHERE term_taxonomy_id=621

/*Вставляем id постов и этот 621 в таблицу связки постов с терминами. Все*/
INSERT INTO 
lex_08_19_term_relationships
	(
	object_id,
	term_taxonomy_id,
	term_order)
SELECT post_id, 621, 0
FROM lex_08_19_postmeta AS meta
WHERE meta.meta_key='voices' and meta.meta_value LIKE 'трио%'

/*всего сколько песен для трио*/
SELECT COUNT(*)
FROM lex_08_19_postmeta
WHERE meta_key = 'voices' AND meta_value LIKE 'трио%'
/*у нас это 64*/

/*Вписать число песен а таблицу term_taxonomy иначе не видно в админке что песни в рубрике есть, видно только на фронте*/
UPDATE lex_08_19_term_taxonomy 
SET count = 64
WHERE term_taxonomy_id = 621

/*Отображение строк 0 - 24
(64 всего, Запрос занял 0,0004 сек.) [object_id: 1918... - 902...]*/
SELECT *
FROM lex_08_19_posts
WHERE ID IN(
	SELECT object_id
FROM lex_08_19_term_relationships
WHERE term_taxonomy_id = 621
)