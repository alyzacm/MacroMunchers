/*

    Group 9
    Part 2 
    ===========
    Parse the hadoop output files to input into cassandra. 
	Make food_names into a list with format ['...', ... , '...'] to make list<text> for food_list attribute in cassandra. 
*/

import java.io.IOException;
import java.io.*;
import java.util.*;
import java.util.concurrent.*;

public class parse_colonCalorie {

    public static void main(String[] args) {

      // The name of the file to open.
        String fileName = args[0];

        // This will reference one line at a time
        String line = null;
        String cals = null; 
        String listString = null; 

        List<String> allFoods = new ArrayList<String>();
      

        try {
            // FileReader reads text files in the default encoding.
            FileReader fileReader = new FileReader(fileName);

            // Always wrap FileReader in BufferedReader.
            BufferedReader bufferedReader = new BufferedReader(fileReader);

            while((line = bufferedReader.readLine()) != null) {

                line = line.replaceAll(",", ";");
                line = line.replaceAll("'", " "); 

                cals = line.substring(0, line.indexOf('\t')); 

                String[] food_item = line.substring(line.indexOf('\t')+1).split(":"); 

                listString = "[\'" + food_item[0] + "\'"; 

                for(String food:food_item){

                  if(!allFoods.contains(food)){
                    listString += ", \'" + food + "\'"; 
                    allFoods.add(food); 
                  }
                }

                listString += "]"; 

                System.out.println(cals + "\t" + listString); 
            }   

            // Always close files.
            bufferedReader.close();         
        }
        catch(FileNotFoundException ex) {
            System.out.println(
                "Unable to open file '" + fileName + "'");                
        }
        catch(IOException ex) {
            System.out.println(
                "Error reading file '" + fileName + "'");                  
        }

    }
}
