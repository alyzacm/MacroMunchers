/*
    CS179G - Part 1 
    
    Group 9
    Alyza Malunao 861065506
    Brittany Seto 861058099
    Justin Jan    861070174
*/

import org.jsoup.Jsoup;
import org.jsoup.helper.Validate;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;
import java.io.IOException;
import java.io.*;
import java.util.Iterator;
import java.util.List;
import java.net.URL; 


public class Crawler_thread implements Runnable{ 

    Crawl crawler; 
    int counter = 0; 
    Thread t;

    public Crawler_thread(Crawl c){
        crawler = c; 
    }; 

    public void run(){
        Document doc; 
        Elements links; 
        String url_string;
        String title; 
        String html_content; 
        boolean shouldFollow; 
        RobotExclusionUtil robot = new RobotExclusionUtil();
        
        try{

            doc = Jsoup.connect(crawler.url).get();
            links = doc.select("a[href]"); 
            title = doc.title(); 
            html_content = doc.html(); 

            saveToFile(title, html_content, crawler.out_file); 

            for(Element link: links){
                url_string = link.attr("abs:href"); 

                url_string = clean(url_string);
                
                //check if in set 
                if(crawler.temp_share.isUnique(url_string) && url_string != null){
                    if(url_string.contains("calorieking.com/calories") || url_string.contains("calorieking.com/food")|| url_string.contains("ndb.nal.usda.gov/")){
                        shouldFollow = robot.robotsShouldFollow(url_string); 
                        if(shouldFollow){
                            Crawl c_temp = new Crawl(crawler.depth++, url_string, crawler.out_file, crawler.temp_share, crawler.max_depth);
                            if(c_temp.depth < c_temp.max_depth){
                                crawler.temp_share.add_into_queue(c_temp); 
                                crawler.temp_share.add_into_set(url_string);        
                            }
                        }
                    }
                }
            }
        }catch(Exception e) {
            //System.out.println("Error while reading file line by line: " + e.getMessage());
        }
        crawler.temp_share.dec();
    }

    //parse HTML/normalize
    public String clean(String link_string){
        // if(link_string.indexOf("https") > -1)
        // {
        //     link_string = null; 
        //     return null; 
        // }
        // if(link_string.indexOf("http") == -1)
        // {
        //     return null;
        // }
        if(link_string.indexOf('#') > -1)
        {
            link_string = link_string.substring(0, link_string.indexOf('#')); 
            link_string = link_string + "/"; 
            return link_string; 
        }
        return link_string;
    }


    public void start()
    {
        t = new Thread(this);
        t.start();
    }

    public void saveToFile(String title, String html_doc, String dirName){
        crawler.temp_share.increment();
        title = crawler.temp_share.title + ". " + title; 

        try{
            FileWriter output_File = new FileWriter(dirName+'/'+title+".html");
            BufferedWriter bufferWriter = new BufferedWriter(output_File);

            output_File.write(html_doc + '\n'); 
            bufferWriter.close(); 
        }catch(Exception e){}
        
    }

    public void thread_interrupt(){
        t.interrupt();  
    }

        

}



