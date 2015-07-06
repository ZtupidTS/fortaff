count(*)

is null

sum(valor_em_credito)

group by

-- o trigger ficam a trabalhar sozinho

-- if no sql
if (..) then
....

end if;

-- não esquecer que não para adicionar valores null para isso fazer assim
select cod_filme,sum(preco + ifnull(multa,0)) ou como o prof gosta
select cod_filme,sum(preco + (case when (multa is null) then 0 else multa end))

-- ao usar AUTO_INCREMENT
na linha de construção da tabela com dados, na coluna auto increment mete se null

-- exemplo de uma criação de uma view
create view multas (socio, num_multas)
    as select n_socio, count(*)
       from alugueres
       where multa > 0 
       group by n_socio
	   
create view -- nome da view	   
	as select -- nome da coluna,
	from
	where	   
-- para ver a view	       
select * from multas 

-- eliminar uma view para poder alterar
drop view -- noma da view

-- saber o valor maximo de uma tabela
multa = (select max(multa)
         from alugueres)
		 
-- criação de uma função
create function multa_a_pagar(modal char(10),dias int)
returns decimal(5,2)
begin

    declare multa decimal(4,2);

    select multa_diaria
    into multa
    from modalidades
    where modalid = modal;

    return (multa * dias);
    

end;

-- ver uma função
select multa_a_pagar ('M01', 10)

-- criar uma procedure
create procedure abrir_aluguer (in socio char(10), filme char(10), copia char(5), moda char(10))
begin

    declare preco_mod decimal (4,2);
    
    select preco
    into preco_mod
    from modalidades
    where modalid = moda;

    insert into alugueres (n_socio, cod_filme, n_copia, modalid, data_aluguer, preco)
      values (socio, filme, copia, moda, now(), preco_mod);
      
    commit; -- para dizer que ta fixo

end;
-- para chamar procedure
call clubevideo.abrir_aluguer(-- aqui inserir os campos definidos na procedure)	

-- trigger

create trigger castigo
before insert on alugueres
for each row 

begin

    declare num_multas int;
    declare moda_max char(10);
    declare preco_max decimal(3,2);
    
    select count(*)
    into num_multas
    from alugueres
    where n_socio = new.n_socio and multa > 0; -- new.n_socio é só para fazer n_socio = n_socio
    
    if (num_multas > 1) then
    
    select modalid, preco
    into moda_max, preco_max
    from alugueres
    where preco = (select max(preco) from modalidades);
     
     set new.modalid = moda_max;
     set new.preco = preco_max;
      
      
   end if;


end;

-- ter cuidado com view para trazer tudo
create view lucro_por_filme (cod_filme, lucro)
    as select c.cod_filme, l.lucro - c.custo
       from custo c, lucro l
       where l.cod_filme = c.cod_filme 
       
select * from lucro_por_filme

-- na minha BD falta filmes comprados mas não alugadas por isso esse outra view
create view lucro_por_filme (cod_filme, lucro)
    as select c.cod_filme, l.lucro - c.custo
       from custo c
            left outer join -- permite trazer todas as colunas da tabela lucro para essa junção
            lucro l
            on l.cod_filme = c.cod_filme 
-- outra no caso de lucro estar a "null"
create view lucro_por_filme (cod_filme, lucro)
    as select c.cod_filme, ifnull(l.lucro,0) - c.custo
       from custo c
            left outer join
            lucro l
            on l.cod_filme = c.cod_filme

