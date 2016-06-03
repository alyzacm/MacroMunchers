import java.io.IOException;
import java.util.StringTokenizer;

import org.apache.hadoop.conf.Configuration;
import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.DoubleWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.Mapper;
import org.apache.hadoop.mapreduce.Reducer;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;

public class Fat{

  public static class TokenizerMapper
       extends Mapper<Object, Text, DoubleWritable, Text>{

	private Text food = new Text();
	private DoubleWritable protein = new DoubleWritable();
	private DoubleWritable fat = new DoubleWritable();
	private DoubleWritable carb = new DoubleWritable();
	private DoubleWritable sum = new DoubleWritable();
	private DoubleWritable pRatio = new DoubleWritable();

    public void map(Object key, Text value, Context context
                    ) throws IOException, InterruptedException {
    	String val = value.toString();
		String[] fields = val.split("\t");
		protein.set(Double.parseDouble(fields[3].substring(0,fields[3].indexOf('g'))));
		fat.set(Double.parseDouble(fields[4].substring(0, fields[4].indexOf('g'))));
		carb.set(Double.parseDouble(fields[5].substring(0, fields[5].indexOf('g'))));
		food.set(fields[0]);
	Double proteinInt = protein.get();
	
	Double fatInt = fat.get();
	Double carbInt = carb.get();
	Double sumInt = proteinInt + fatInt + carbInt;
		sum.set(sumInt);
		pRatio.set(fatInt/ sumInt);
		context.write(pRatio, food);
	}
  }

  public static class IntSumReducer
       extends Reducer<DoubleWritable,Text, DoubleWritable,Text> {
    private Text result = new Text();

    public void reduce(DoubleWritable key, Iterable<Text> values,
                       Context context
                       ) throws IOException, InterruptedException {
      String foods = "";
	for (Text val : values) {
        foods +=  val + ":";
      }
      result.set(foods);
      context.write(key, result);
    }
  }

  public static void main(String[] args) throws Exception {
    Configuration conf = new Configuration();
    Job job = Job.getInstance(conf, "fat");
    job.setJarByClass(Fat.class);
    job.setMapperClass(TokenizerMapper.class);
//    job.setCombinerClass(IntSumReducer.class);
    job.setReducerClass(IntSumReducer.class);
    job.setOutputKeyClass(DoubleWritable.class);
    job.setOutputValueClass(Text.class);
    FileInputFormat.addInputPath(job, new Path(args[0]));
    FileOutputFormat.setOutputPath(job, new Path(args[1]));
    System.exit(job.waitForCompletion(true) ? 0 : 1);
  }
}
