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

SELECT * FROM V_Record as vr
WHERE EXISTS(
    SELECT hol.BDate
    FROM Holiday hol
    WHERE CONVERT(VARCHAR(10),vr.CheckTime,110) = CONVERT(VARCHAR(10),hol.BDate,110)
)
order by CheckTime



/* inventario */
/* v1 */
SELECT *
FROM V_Record as vr
WHERE EXISTS(
    SELECT hol.BDate
    FROM Holiday hol
    WHERE CONVERT(VARCHAR(10),vr.CheckTime,110) = CONVERT(VARCHAR(10),hol.BDate,110) AND hol.Name LIKE '%INV%'
)
order by CheckTime

/* v2 */
SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia, hol.Name as Name 
FROM V_Record as vr, Holiday as hol 
WHERE vr.CheckTime between '2016-04-01 03:30:01.000' and DATEADD(DAY,1,'2016-04-24 03:30:00.000') AND hol.Name LIKE '%INV%' 
order by CheckTime

/* v3 */
SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia, hl.Name
FROM V_Record as vr, Holiday hl
WHERE vr.Userid = 12 AND vr.CheckTime between '2016-04-01 03:30:01.000' and DATEADD(DAY,1,'2016-04-30 03:30:01.000') AND hl.Name LIKE '%INV%' AND EXISTS (
SELECT hol.BDate, hol.Name
FROM Holiday hol 
WHERE CONVERT(VARCHAR(10),vr.CheckTime,110) = CONVERT(VARCHAR(10),hol.BDate,110) AND hol.Name LIKE '%INV%') 
order by CheckTime

/* v4 */
-- nessa versão primeiro vou ir buscar os meus dia e devolvo isso
select CONVERT(VARCHAR(10),format(BDate, 'yyyy-MM-dd'),110) as datestart, CONVERT(VARCHAR(10),format(DATEADD(DAY,1,BDate), 'yyyy-MM-dd'),110) as dateend
from Holiday
where BDate between '2016-04-21 00:00:00.000' and DATEADD(DAY,1,'2016-04-23 03:30:01.000') AND Name LIKe '%INV%'

-- depois com a ajdua do php meto os valores nessa 2ª query e obtenho o que pretendo
SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia, hol.Name as Name 
FROM V_Record as vr, Holiday as hol 
WHERE vr.Userid = 12 AND (vr.CheckTime between '2016-04-24 03:30:01.000' and '2016-04-25 03:30:00.000' or vr.CheckTime between '2016-04-22 03:30:01.000' and '2016-04-23 03:30:00.000' or vr.CheckTime between '2016-04-01 03:30:01.000' and '2016-04-29 03:30:00.000') AND hol.Name LIKE '%INV%' AND (Format(vr.CheckTime, 'dd/MM/yyyy') = Format(hol.BDate, 'dd/MM/yyyy') or Format(vr.CheckTime, 'dd/MM/yyyy') = format(DATEADD(DAY,1,hol.BDate),'dd/MM/yyyy'))
order by CheckTime

/* v5 */
-- nessa versão primeiro vou ir buscar os meus dia e devolvo isso
-- mudei o date add aqui
select CONVERT(VARCHAR(10),format(BDate, 'yyyy-MM-dd'),110) as datestart, CONVERT(VARCHAR(10),format(DATEADD(DAY,1,BDate), 'yyyy-MM-dd'),110) as dateend
from Holiday
where BDate between '2016-04-21 00:00:00.000' and '2016-04-23 03:30:01.000' AND Name LIKe '%INV%'

-- depois com a ajdua do php meto os valores nessa 2ª query e obtenho o que pretendo
SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia, hol.Name as Name 
FROM V_Record as vr, Holiday as hol 
WHERE vr.Userid = 12 AND (vr.CheckTime between '2016-04-24 03:30:01.000' and '2016-04-25 03:30:00.000' or vr.CheckTime between '2016-04-22 03:30:01.000' and '2016-04-23 03:30:00.000' or vr.CheckTime between '2016-04-01 03:30:01.000' and '2016-04-29 03:30:00.000') AND hol.Name LIKE '%INV%' AND (Format(vr.CheckTime, 'dd/MM/yyyy') = Format(hol.BDate, 'dd/MM/yyyy') or Format(vr.CheckTime, 'dd/MM/yyyy') = format(DATEADD(DAY,1,hol.BDate),'dd/MM/yyyy'))
order by CheckTime


/* feriado */

/* v1 */
SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia 
FROM V_Record as vr WHERE vr.Userid = 12 AND vr.CheckTime between '2016-04-24 03:30:01.000' and DATEADD(DAY,1,'2016-04-24 03:30:01.000') AND EXISTS(
SELECT hol.BDate 
FROM Holiday hol 
WHERE CONVERT(VARCHAR(10),vr.CheckTime,110) = CONVERT(VARCHAR(10),hol.BDate,110) AND hol.Name NOT LIKE '%INV%') 
order by CheckTime

/* v2 */ 
SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia 
FROM V_Record as vr, Holiday as hol
WHERE vr.Userid = 12 AND vr.CheckTime between '2016-04-01 03:30:01.000' and DATEADD(DAY,1,'2016-04-30 03:30:01.000') AND hol.Name NOT LIKE '%INV%' AND hol.BDate between '2016-04-24' and DATEADD(DAY,1,'2016-04-24')
order by CheckTime

/* v3 */
SELECT FORMAT(vr.CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia 
FROM V_Record as vr
WHERE vr.Userid = 12 AND vr.CheckTime between '2016-04-01 03:30:01.000' and DATEADD(DAY,1,'2016-04-30 03:30:01.000') AND EXISTS (
SELECT hol.BDate 
FROM Holiday hol 
WHERE CONVERT(VARCHAR(10),vr.CheckTime,110) = CONVERT(VARCHAR(10),hol.BDate,110) AND hol.Name NOT LIKE '%INV%') 
order by CheckTime


/* Domingos */

/* v1 */

SELECT *
FROM V_Record
WHERE DATEPART(dw, CheckTime) IN (1)
order by CheckTime

/* v2 */

SELECT FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia 
FROM V_Record 
WHERE CheckTime between '2016-04-20 03:30:01.000' and DATEADD(DAY,1,'2016-04-26 03:30:00.000') AND DATEPART(dw, CheckTime) IN (1,2) AND CONVERT(varchar, attributeName,108) between '03:30:00' AND '03:30:00'
order by CheckTime

/* v3 */

select FORMAT(CheckTime, 'HH:mm:ss') as horas, Format(CheckTime, 'dd/MM/yyyy') as dia
from V_Record 
WHERE Userid = ".$data['Userid']." AND CAST(DATEPART(dw, checktime) AS VARCHAR) + FORMAT(checktime, 'HHmm') between 10330 and 20330 AND CheckTime between '".$datefirst." ".FIRST_TIME."' and DATEADD(DAY,1,'".$datesecond." ".LAST_TIME."')
order by CheckTime