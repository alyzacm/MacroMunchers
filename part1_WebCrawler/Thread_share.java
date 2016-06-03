/*
	CS179G - Part 1 
	
	Group 9
	Alyza Malunao 861065506
	Brittany Seto 861058099
	Justin Jan 	  861070174
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

public class Thread_share{

	public BlockingQueue<Crawl> main_queue = new LinkedBlockingQueue<Crawl>(); // poll = dequeue, add - enqueue
	public HashSet<String> set_of_URLs = new HashSet<String>(); 
	public int title;
	public int threadcount;

	public Thread_share(BlockingQueue<Crawl> q, HashSet<String> s){
		main_queue = q;
		set_of_URLs = s; 
		title  = 0;
		threadcount =0;
	}

	public void add_into_set(String url){
		set_of_URLs.add(url); 
	}

	public boolean isUnique(String url){
		if(set_of_URLs.contains(url))
			return false; 
		return true;  
	}

	public void print_set(){
		for(String s : set_of_URLs){
			System.out.println(s); 
		} 
	}

	public void print_queue(){
		for(Crawl s : main_queue){
			s.print();
		} 
	}

	public void add_into_queue(Crawl c){
		try{
			main_queue.put(c); 
		}catch(Exception e){
			System.out.println("Error inserting into queue.");
		}
		
	}

	public int size_of_set(){
		return set_of_URLs.size(); 
	}

	public int size_of_queue(){
		return main_queue.size(); 
	}

	public boolean isEmpty(){
		if(main_queue.peek() == null)
			return true; 
		return false; 
	}

	public Crawl pop(){
		return main_queue.poll(); 
	}

	public Crawl firstElem()
	{
		return main_queue.peek();
	}
	public synchronized void increment() {
		++title;
	}
	public synchronized void inc(){
		++threadcount;
	}
	public synchronized void dec(){
		--threadcount;
	}
	public synchronized int getit(){
			
		return threadcount;
	}
}