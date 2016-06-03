CREATE TABLE calories ( 
	calCount int, 
	foodItems list<text>, 
	PRIMARY KEY(calCount));

copy calories (calCount, foodItems)  
from '~/Desktop/part2/parsedHadoopOutputs/output_semicolonCal.txt' 
with delimiter = '\t';

CREATE TABLE protein ( 
	protein_ratio double, 
	foodItems list<text>, 
	PRIMARY KEY(protein_ratio));

copy protein (protein_ratio, foodItems)  
from '~/Desktop/part2/parsedHadoopOutputs/output_proteinRatio.txt' 
with delimiter = '\t';

CREATE TABLE carbs ( 
	carbs_ratio double, 
	foodItems list<text>, 
	PRIMARY KEY(carbs_ratio));

copy carbs (carbs_ratio, foodItems)  
from '~/Desktop/part2/parsedHadoopOutputs/output_carbRatio.txt' 
with delimiter = '\t';

CREATE TABLE fats ( 
	fat_ratio double, 
	foodItems list<text>, 
	PRIMARY KEY(fat_ratio));

copy fats (fat_ratio, foodItems)  
from '~/Desktop/part2/parsedHadoopOutputs/output_fatRatio.txt' 
with delimiter = '\t';