/* dados default */

select * from autoinc where codigo = 'IDMOV'

select codtmv_pedido, filial_pedido from paramgeral

select
  parammov.statusdefault,
  parammov.seriedefault,
  parammov.clifordefault,
  parammov.naturezadefault,
  parammov.condpgtodefault,
  parammov.contacaixadefault
from parammov where codtmv = '2.2.20'


select * from serie where serie = '3'


select * from parammovtloc where codtmv = '2.2.20' and filial = 1

select * from usuario
select * from funcionario


/* dados digitados */
		inserir tmov = cabecalho
        titmmov = itens
		nr mesa

select tmov.pedcliente, tmov.valorliquido, tmov.valorbruto from tmov

select
   titmmov.sequencial,
   titmmov.idprd,
   titmmov.codgrade, /* se tiver uma na tprdgrade assume, caso contrario escolhe */
   titmmov.compldescricao, /* onde vai colocar o texto do que vai acionar ou retirar, tabela tprd filtrar por codtb1 = 99, e campo preco1 para acrescentar */
   titmmov.valoracrescimo,
   titmmov.codnat, /* pegar da tmov.codnat */
   titmmov.quantidadeoriginal,
   titmmov.valorunitario, /* busca da tprd.preco1 */
   titmmov.valortotal, /* (titmmov.valorunitario * titmmov.quantidadeoriginal) + titmmov.valoracrescimo

from titmmov

/* produto */
select idprd, codigoprd, nomefantasia, preco1 from tprd

/* grade */
select * from tprdgrade