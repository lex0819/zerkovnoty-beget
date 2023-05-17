SELECT SQL_CALC_FOUND_ROWS  lex_08_19_posts
.ID 
FROM lex_08_19_posts  
LEFT JOIN lex_08_19_term_relationships 
ON
(lex_08_19_posts.ID = lex_08_19_term_relationships.object_id)  
LEFT JOIN lex_08_19_term_relationships AS tt1 
ON
(lex_08_19_posts.ID = tt1.object_id)  
LEFT JOIN lex_08_19_term_relationships AS tt2 
ON
(lex_08_19_posts.ID = tt2.object_id)  
LEFT JOIN lex_08_19_term_relationships AS tt3 
ON
(lex_08_19_posts.ID = tt3.object_id) 
WHERE  
  lex_08_19_term_relationships.term_taxonomy_id IN
(111) 
  AND 
  tt1.term_taxonomy_id IN
(72) 
  AND 
  tt2.term_taxonomy_id IN
(618) 
  AND 
  tt3.term_taxonomy_id IN
(620)

AND lex_08_19_posts.post_title LIKE 'херувимская'
AND lex_08_19_posts.post_type = 'lex_kliros_noty' 
