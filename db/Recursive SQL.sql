with recursive tmp as (

select 
f.father_id,
f.name,
row_number() over() as row_numb--over (partition by name)
from structure f
where f.name like 'image%'

union all

select
s.father_id,
s.name,
p.row_numb
from structure s
join tmp p on p.father_id = s.id
)
select * from tmp order by row_numb, coalesce(father_id, 0)
