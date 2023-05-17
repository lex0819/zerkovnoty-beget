SELECT lex_08_19_terms.term_id, lex_08_19_terms.name, lex_08_19_terms.slug,
	lex_08_19_term_taxonomy.count
FROM lex_08_19_terms

	LEFT JOIN lex_08_19_term_taxonomy
	ON (lex_08_19_term_taxonomy.term_id = lex_08_19_terms.term_id)
WHERE lex_08_19_term_taxonomy.taxonomy='lex_kliros_composer'
ORDER BY lex_08_19_terms.name ASC