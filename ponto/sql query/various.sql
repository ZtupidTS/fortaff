/* relativo ao resumo horas trabalhadas */

select count(DISTINCT(day(CheckTime))), Name
from V_Record
where Deptid = 18
group by year(CheckTime),month(CheckTime),day(CheckTime), Name

select COUNT(DISTINCT(CheckTime))
from V_Record
where Userid = 198

SELECT COUNT(DISTINCT CAST(CheckTime AS DATE))
FROM   V_Record
WHERE  CheckTime >= '20160409' AND CheckTime < '20160421' 

select DISTINCT Userid, Name
from V_Record
where Deptid = 13

select FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/mm/yyyy') as dia
from V_Record
where Userid = 225
order by CheckTime

SELECT *
FROM V_Record
WHERE DATEPART(dw, CheckTime) IN (1)
order by CheckTime

SELECT * FROM V_Record as vr
WHERE EXISTS(
    SELECT hol.BDate
    FROM Holiday hol
    WHERE CONVERT(VARCHAR(10),vr.CheckTime,110) = CONVERT(VARCHAR(10),hol.BDate,110)
)
order by CheckTime

SELECT * FROM V_Record as vr
WHERE EXISTS(
    SELECT hol.BDate
    FROM Holiday hol
    WHERE CONVERT(VARCHAR(10),vr.CheckTime,110) = CONVERT(VARCHAR(10),hol.BDate,110) AND hol.Name LIKE '%INVENTARIO%'
)
order by CheckTime