-- view da tabela elemento_equipa para ver o cod_equipa e num_total_element (total_elemento_equipa)

SELECT cod_equipa, COUNT(*) as total
FROM elemento_in_equipa
WHERE estado_valido != 'X'
group by cod_equipa

-- view para ver as equipas onde existe uma delegação criada para elas na tabela delegação, assim retiro os erros de inserção
-- (equipa_with_delegacao)

SELECT eq.cod_equipa AS cod_equipa, mo.nome_modalidade AS nome_modalidade, de.nome_pais AS nome_pais, eq.estado_valido AS estado_valido, de.cod_delegacao, mo.cod_modalidade, eq.sexo
FROM equipa eq, modalidade mo, delegacao de
WHERE eq.cod_modalidade = mo.cod_modalidade and eq.cod_delegacao = de.cod_delegacao and de.estado_valido != 'X' and eq.estado_valido != 'X'

-- view para ver a classificação média de um evento (classificacao_media_evento)

SELECT ev.cod_evento, (SUM(classificacao)/count(*)) as classif_media, count(*) as votos
FROM evento ev, classificacao_evento cl
WHERE ev.cod_evento = cl.cod_evento
group by ev.cod_evento

-- view pais_notin_delegacao

SELECT pa.nome_pais, pa.prefix_pais
from pais pa
where not exists
(select * 
from delegacao de
where de.nome_pais = pa.nome_pais and estado_valido != 'X')

-- view dos atletas (dados_atletas)

SELECT eq.cod_equipa, el.cod_elemento_equipa, el.nome, el.data_nasc, el.sexo, at.peso, at.altura, at.grupo_sanguineo, de.cod_delegacao, de.nome_pais, ei.estado_valido
FROM elemento_equipa el, atleta at, elemento_in_equipa ei, delegacao de, equipa eq
WHERE el.cod_elemento_equipa = at.cod_elemento_equipa and ei.cod_elemento_equipa = el.cod_elemento_equipa and ei.cod_equipa = eq.cod_equipa and eq.cod_delegacao = de.cod_delegacao

-- view dos auxiliares (dados_auxiliares)

SELECT eq.cod_equipa, el.cod_elemento_equipa, el.nome, el.data_nasc, el.sexo, au.funcao, au.habilit_literarias, de.cod_delegacao, de.nome_pais, ei.estado_valido
FROM elemento_equipa el, auxiliar au, elemento_in_equipa ei, equipa eq, delegacao de
WHERE el.cod_elemento_equipa = au.cod_elemento_equipa and ei.cod_elemento_equipa = el.cod_elemento_equipa and ei.cod_equipa = eq.cod_equipa and eq.cod_delegacao = de.cod_delegacao

-- view para lugares vazios das provas (lugares_vazios)

SELECT cod_prova, (lugares_total - lugares_reservados) as lugar_vazios
FROM prova

-- view para lugares vazios dos eventos (lugares_vazios_evento)

SELECT cod_evento, (lugares_total - lugares_reservados) as lugar_vazios
FROM evento

-- view para elemento em equipa com o prefix da delegação (elemento_delegacao)

SELECT eq.cod_equipa, eq.cod_delegacao, ei.cod_elemento_equipa
FROM elemento_in_equipa ei, equipa eq
WHERE eq.cod_equipa = ei.cod_equipa

-- view para associar equipas com as provas (associar_eq_prova)

SELECT eq.cod_equipa, pr.cod_prova, eq.cod_modalidade, mo.nome_modalidade, eq.sexo, eq.cod_delegacao
FROM modalidade mo, equipa eq, prova pr
WHERE eq.cod_modalidade = mo.cod_modalidade and mo.tipo = 'C' and eq.estado_valido = 'V' and pr.estado_valido = 'V' and pr.cod_modalidade = eq.cod_modalidade and pr.sexo = eq.sexo and eq.cod_equipa not in

(SELECT cod_do_classificado
FROM classificacao_prova cl
WHERE cl.cod_prova = pr.cod_prova and estado_valido_classificado != 'X')

-- view para ver as equipas associadas a uma prova (eq_acrescentado_a_prova)

SELECT eq.cod_equipa, pr.cod_prova, pr.cod_modalidade, mo.nome_modalidade, pr.sexo, eq.cod_delegacao, cl.classificacao
FROM classificacao_prova cl, prova pr, equipa eq, modalidade mo
WHERE cl.cod_prova = pr.cod_prova and pr.cod_modalidade = mo.cod_modalidade and mo.tipo = 'C' and eq.estado_valido != 'X' and eq.cod_equipa in 

(SELECT cod_do_classificado
FROM classificacao_prova cp
WHERE cl.cod_do_classificado = cp.cod_do_classificado and cl.estado_valido_classificado = 'V')

-- view para associar atletas a uma prova (associar_atl_prova)

SELECT eq.cod_equipa, pr.cod_prova, eq.cod_modalidade, mo.nome_modalidade, eq.sexo, eq.cod_delegacao, el.cod_elemento_equipa, el.estado_valido, ee.nome
FROM modalidade mo, equipa eq, prova pr, elemento_in_equipa el, elemento_equipa ee
WHERE eq.cod_modalidade = mo.cod_modalidade and mo.tipo = 'I' and eq.estado_valido = 'V' and pr.estado_valido = 'V' and pr.cod_modalidade = eq.cod_modalidade and pr.sexo = eq.sexo and eq.cod_equipa = el.cod_equipa and el.estado_valido = 'V' and ee.cod_elemento_equipa = el.cod_elemento_equipa and el.cod_elemento_equipa not in

(SELECT cod_do_classificado
FROM classificacao_prova cl
WHERE cl.cod_prova = pr.cod_prova and estado_valido_classificado != 'X')

-- view para ver os atletas associados a uma prova (atl_acrescentado_a_prova)

SELECT distinct el.cod_elemento_equipa, eq.cod_equipa, pr.cod_prova, pr.cod_modalidade, mo.nome_modalidade, pr.sexo, eq.cod_delegacao, ee.nome, cl.classificacao
FROM classificacao_prova cl, prova pr, equipa eq, modalidade mo, elemento_in_equipa el, elemento_equipa ee
WHERE cl.cod_prova = pr.cod_prova and pr.cod_modalidade = mo.cod_modalidade and mo.tipo = 'I' and eq.estado_valido != 'X' and eq.cod_equipa = el.cod_equipa and el.cod_elemento_equipa != 'X' and el.cod_elemento_equipa = ee.cod_elemento_equipa and el.cod_elemento_equipa in 

(SELECT cod_do_classificado
FROM classificacao_prova cp
WHERE cl.cod_do_classificado = cp.cod_do_classificado and cl.estado_valido_classificado = 'V')

-- tipo de prova (tipo_prova)

SELECT pr.cod_prova, pr.sexo, pr.cod_modalidade, mo.nome_modalidade, mo.tipo
FROM prova pr, modalidade mo
WHERE pr.cod_modalidade = mo.cod_modalidade and pr.estado_valido = 'V'

-- associar um elemento a uma delegacao (associar_el_delegacao)

SELECT distinct ee.cod_elemento_equipa, de.cod_delegacao, ee.nome
FROM elemento_equipa ee, elemento_in_equipa el, equipa eq, delegacao de
WHERE ee.cod_elemento_equipa = el.cod_elemento_equipa and el.estado_valido = 'V' and el.cod_equipa = eq.cod_equipa and eq.cod_delegacao = de.cod_delegacao

-- saber a classificacao de uma equipa inscrita numa prova (classifcacao_equipa)

SELECT eq.cod_equipa, eq.cod_prova, eq.sexo, eq.cod_delegacao, cl.classificacao, de.nome_pais
from eq_acrescentado_a_prova eq, classificacao_prova cl, delegacao de
where eq.cod_equipa = cl.cod_do_classificado and eq.cod_prova = cl.cod_prova and cl.estado_valido_classificado = 'V' and eq.cod_delegacao = de.cod_delegacao

-- saber a classificacao de um atleta inscrito numa prova (classifcacao_atleta)

SELECT at.cod_elemento_equipa, at.cod_prova, at.sexo, at.cod_delegacao, cl.classificacao, de.nome_pais
from atl_acrescentado_a_prova at, classificacao_prova cl, delegacao de
where at.cod_elemento_equipa = cl.cod_do_classificado and at.cod_prova = cl.cod_prova and cl.estado_valido_classificado = 'V' and at.cod_delegacao = de.cod_delegacao

-- ver dados completos de reserva e compra de evento (co_re_evento)

SELECT rc.id_vis, ev.cod_evento, ev.data, ev.hora_inicio, ev.duracao, rc.re_ou_com, ev.lat, ev.lng
FROM reserva_compra rc, evento ev
WHERE rc.tipo = 'EV' and rc.cod_sessao = ev.cod_evento

-- ver dados completos de reserva e compra de evento (co_re_prova)

SELECT rc.id_vis, pr.cod_prova, pr.data, pr.hora_inicio, pr.duracao, mo.nome_modalidade, rc.re_ou_com, pr.lat, pr.lng
FROM reserva_compra rc, prova pr, modalidade mo
WHERE rc.tipo = 'PR' and rc.cod_sessao = pr.cod_prova and pr.cod_modalidade = mo.cod_modalidade