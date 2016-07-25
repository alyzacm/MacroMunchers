# MacroMunchers
Find foods that match your calorie range and macro ratios.


Part 1: Data Collection 
- Implemented a web crawler to collect 5GB of data 
- Data collected consists of only food related websites that contain nutritional information

Part 2: Hadoop Data Processing and storing into Cassandra 
- Parsed all the nutritional values from the HTML files collected from Part 1 for each food item
- Used Hadoop to process data for macro ratios for each of the following: 
  - Calories
  - Protein 
  - Fats 
  - Carbs
- The values generated from Hadoop will be stored in four different tables in Cassandra

Part 3: Web Interface 
- Built a web interface to explore the preprocessed or analyzed data
- Web page uses PHP and HTML/CSS/JavaScript for each of the following (displayed by a Web Server): 
  - Homepage
  - Calories
  - Macros


Screenshots: 
- Homepage: 
  - <img width="539" alt="screen shot 2016-07-24 at 12 21 54 pm" src="https://cloud.githubusercontent.com/assets/10494511/17110987/66bc8136-5254-11e6-885a-05b617cf126c.png">

- Calories:
  - <img width="539" alt="screen shot 2016-07-24 at 12 22 07 pm" src="https://cloud.githubusercontent.com/assets/10494511/17110997/7176eeae-5254-11e6-85ed-b78a2f6b6d1e.png">
  
- Macros: 
  - <img width="525" alt="screen shot 2016-07-24 at 12 22 22 pm" src="https://cloud.githubusercontent.com/assets/10494511/17111007/79231b5a-5254-11e6-8f54-e3008eda7ef4.png">



