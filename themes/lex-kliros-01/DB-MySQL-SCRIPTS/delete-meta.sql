/*проверка записей с мета полями*/
SELECT *
FROM lex_08_19_postmeta
WHERE meta_key = 'quality'

SELECT *
FROM lex_08_19_postmeta
WHERE meta_key = 'quality' AND meta_value LIKE 'смеш%'

/*всего сколько песен для однородного хора*/
SELECT COUNT(*)
FROM lex_08_19_postmeta
WHERE meta_key = 'quality' AND meta_value LIKE 'однород%'

SELECT *
FROM lex_08_19_postmeta
WHERE meta_key = 'voices'

SELECT *
FROM lex_08_19_postmeta
WHERE meta_key = 'voices' AND meta_value LIKE 'квартет%'

/*Удаляем quality и voices вообще из базы*/
/*Эти мета поля не нужны в каждом посте, они лучше в таксономиях как отдельные таблицы*/
DELETE 
FROM lex_08_19_postmeta
WHERE meta_key IN ('quality','voices')

/*Удаляем SEO RANK Math*/
DELETE 
FROM lex_08_19_postmeta
WHERE meta_key LIKE 'rank%'