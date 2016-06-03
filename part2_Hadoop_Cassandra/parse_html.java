/*

	Group 9
	Part 2 
	===============
	Parse html files to grab food_name and nutrition facts (calories, proteins, fats, carbs, fiber, and sugar). 

*/

import org.jsoup.Jsoup;
import org.jsoup.helper.Validate;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;
import java.io.IOException;
import java.io.*;
import java.util.*;
import java.util.concurrent.*;

public class parse_html {

	public static void listFilesForFolder(final File folder) {
	    for (final File fileEntry : folder.listFiles()) {
	        if (fileEntry.isDirectory()) {
	            listFilesForFolder(fileEntry);
	        } else {
	            parse_html(folder.getName(), fileEntry.getName()); 
	        }
	    }
	}

	public static void parse_html(String folder, String file_name){

    	Document doc; 
        Elements links; 
        String user_url;
        String url_string; 
        String title; 
        String food_name;
        String temp; 
        String calories, protein, fats, carbs, fiber, sugars; 
        Elements nutrition; 
        String serving_size; 
        Elements view_name; 
        List<String> nut_list = new ArrayList<String>(); 
        List<Integer> list_num = new ArrayList<Integer>(); 
        list_num.add(0); //calories
        list_num.add(8); //protein
        list_num.add(1); //fats
        list_num.add(5); //carbs
        list_num.add(6); //fiber
        list_num.add(7); //sugars

        List<String> url_list = new ArrayList<String>();

		try{
        	File input = new File(folder + "/" + file_name); 
    		doc = Jsoup.parse(input, "UTF-8", "http://example.com/");

        	// ================= CALORIEKING ================= //

    		if(doc.title().contains("Calories")){
	        	// get food name 
	        	title = doc.title(); 
	        	food_name = title.substring(12, title.indexOf('|')-1); 
	        	temp = food_name + "\t"; 

	        	// get serving size
	        	Elements options = doc.select("#units > option");
				serving_size = options.get(0).text(); 
				temp += serving_size + "\t"; 

	        	// get calories 
	        	nutrition = doc.select("div#mNutrient"); 

	      		for(Element element : nutrition){
	      			for(Element n : element.getElementsByTag("td")){
	      				if(n.className().contains("amount") || n.className().contains("calories")){
	  						nut_list.add(n.text()); 
	      				}
	      			}
	      		}

				for(int i = 0; i < list_num.size(); i++){
					if(nut_list.get(list_num.get(i)).contains("< ")){
						temp += "0g\t"; 
					}
					else {
						temp += nut_list.get(list_num.get(i)) + "\t"; 
					}
				}

	      		//remove "Calories from string"
	      		int c_index = temp.indexOf("Calories"); 
	      		String temp1 = temp.substring(0, c_index); 
	      		String temp2 = temp.substring(c_index+9); 
	      		temp = temp1 + temp2; 

	      		System.out.println(temp); 
	      		temp = ""; 
      		}
      		

			    		
      		// ================= USDA ================= //
      		else{
      			// get food name
      			view_name = doc.select("div#view-name"); 
      			title = view_name.text(); 
      			title = title.substring(title.indexOf(',')+2); 
      			
      			temp = title + "\tValue per 100g\t"; 

      			nutrition = doc.select("div.nutlist"); 
      			Elements rows = nutrition.select("tr"); 
      			Elements n = rows.select("td"); 

      			for(int i = 4; i < 10; i++){
      				Element row = rows.get(i); 
      				Elements cols = row.select("td"); 

      				if(i == 4){
      					temp += cols.get(2).text() + "\t"; 
      				}
      				else {
      					temp += cols.get(2).text() + "g\t"; 
      				}
      				
      			}

      			System.out.println(temp); 
      			temp = ""; 
      		}
      		

	    } catch(Exception e){
	    	//System.out.println("Error parsing html.\n"); 
	    }

	}

    public static void main(String[] args) {

	List<String> dir_list = new ArrayList<String>(); 
	dir_list.add("USDA"); 
	dir_list.add("USDA_2");
	dir_list.add("USDA_3"); 
	dir_list.add("USDA_4"); 

	for(String d : dir_list){
        	final File folder = new File(d);
		listFilesForFolder(folder);
    	}
    }
}
