/*

    Group 9
    Part 2 
    ===========
    Parse the hadoop output files to input into cassandra. 

*/

import java.io.IOException;
import java.io.*;
import java.util.*;
import java.util.concurrent.*;

public class parse_roundRatios {

    public static void main(String[] args) {

      // The name of the file to open.
        String fileName = args[0];

        // This will reference one line at a time
        String line = null;
        String ratio = null; 
        String listString = null; 
        Double d_ratio; 

        List<String> allFoods = new ArrayList<String>();
      

        try {
            // FileReader reads text files in the default encoding.
            FileReader fileReader = new FileReader(fileName);

            // Always wrap FileReader in BufferedReader.
            BufferedReader bufferedReader = new BufferedReader(fileReader);

            while((line = bufferedReader.readLine()) != null) {

                //line = line.replaceAll(",", ";");
                //line = line.replaceAll("'", " "); 

                ratio = line.substring(0, line.indexOf('\t')); 
                d_ratio = Double.parseDouble(ratio); 


                String[] food_item = line.substring(line.indexOf('\t')+1).split(":"); 

                listString = food_item[0]; 

                // for(String food:food_item){

                //   if(!allFoods.contains(food)){
                //     listString += ", \'" + food + "\'"; 
                //     allFoods.add(food); 
                //   }
                // }

                // listString += "]"; 


                System.out.printf("%.3f", d_ratio);
                System.out.println("\t" + listString); 
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