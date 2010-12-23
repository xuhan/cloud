import java.net.*;
import java.io.*;
import java.util.*;

import java.lang.management.ManagementFactory;
import java.lang.management.OperatingSystemMXBean;
import java.lang.reflect.Method;
import java.lang.reflect.Modifier;
import java.util.Date;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
public class TCPServer {
	public static void main (String args[]) {
		try{
			int serverPort = 1025; // the server port
			ServerSocket listenSocket = new ServerSocket(serverPort);
			System.out.println("Listening "+serverPort);
			while(true) {
				Socket clientSocket = listenSocket.accept();
				System.out.println("New Connection!");
				Connection c = new Connection(clientSocket);
			}
		} catch(IOException e) {System.out.println("Listen socket:"+e.getMessage());}
	}
}
class Connection extends Thread {
	DataInputStream in;
	BufferedReader inFromClient; 
	DataOutputStream out;
	Socket clientSocket;
	public Connection (Socket aClientSocket) {
		try {
			clientSocket = aClientSocket;
			inFromClient =
               			new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
			out =new DataOutputStream( clientSocket.getOutputStream());
			this.start();
		} catch(IOException e) {System.out.println("Connection:"+e.getMessage());}
	}
	public void run(){
		try {			                 

			String data = inFromClient.readLine();
			
			String outdata = printTop();             
			outdata += printUsage();
			//System.out.println(data);
			out.writeBytes(outdata);
		}catch (EOFException e){System.out.println("EOF:"+e.getMessage());
		} catch(IOException e) {System.out.println("readline:"+e.getMessage());
		} finally{ try {clientSocket.close();}catch (IOException e){/*close failed*/}}
		

	}



private static String printUsage() {
	String data = "";
  OperatingSystemMXBean operatingSystemMXBean = ManagementFactory.getOperatingSystemMXBean();
for (Method method : operatingSystemMXBean.getClass().getDeclaredMethods()) {
    method.setAccessible(true);
    if (method.getName().startsWith("get") 
        && Modifier.isPublic(method.getModifiers())) {
            Object value;
        try {
            value = method.invoke(operatingSystemMXBean);
        } catch (Exception e) {
            value = e;
        } // try
        data += method.getName() + " = " + value+"\n";
    } // if
  } // for
  return data;
}

private static String printTop(){
  	DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
        Date date = new Date();
        String sum = "";
	sum+="Time="+dateFormat.format(date)+"\n";  

   try {
      String line;
     // Process p = Runtime.getRuntime().exec("/usr/bin/top -n 1");
	/*List<String> command = new ArrayList<String>();
    	command.add("/usr/bin/top");
    	command.add("-n");
    	command.add("1");
      ProcessBuilder builder = new ProcessBuilder(command);
      Process process = builder.start();
*/
	BufferedReader outputReader = null;    
	String command = "/usr/bin/top -b -n 1";

	int i=0;


	Process proc = Runtime.getRuntime().exec(command);        
	outputReader = new BufferedReader(new InputStreamReader(proc.getInputStream()));        
	while(true){
		try            
		{    
  			Thread.sleep(300);          
			while ( outputReader.ready())                
			{       

				line = outputReader.readLine();    
        if (line.startsWith("Tasks")){
        	String tmp[] = line.split("[:\\s,]+");
        	
        	sum+="Task total="+tmp[1]+"\n";
    		sum+="Task running="+tmp[3]+"\n";
    		sum+="Task sleeping="+tmp[5]+"\n";
    		sum+="Task stopped="+tmp[7]+"\n";
    		sum+="Task zombie="+tmp[9]+"\n";
        }
        if (line.startsWith("Cpu")){
        	String tmp[] = line.split("[:\\s,%]+");
        	for (i=0; i<tmp.length; i++){
        		//System.out.println(tmp[i]);
        	}
        	sum+="Cpu usage User="+tmp[1]+"\n";
    		sum+="Cpu usage System="+tmp[3]+"\n";
    		sum+="Cpu usage Idle="+tmp[7]+"\n";
        }
        if (line.startsWith("Mem")){
        	String tmp[] = line.split("[:\\s,]+");
        	for (i=0; i<tmp.length; i++){
        		//System.out.println(tmp[i]);
        	}
    		sum+="Memory total="+tmp[1]+"\n";
    		sum+="Memory used="+tmp[3]+"\n";
    		sum+="Memory free="+tmp[5]+"\n";
    		sum+="Memory buffers="+tmp[7]+"\n";
		break;
        }
            
			}                
			// see if the process has exited                
			int exitValue = proc.exitValue();                
			//System.out.println("Process exited with code: " + exitValue);                
			break;            
		}            
		catch(IOException ioex)            
		{                
			ioex.printStackTrace();            
		}            
		catch( IllegalThreadStateException itex)            
		{                
			// program is still running!            
		}        
	}	


    }
    catch (Exception err) {
      err.printStackTrace();
    }
return sum;
}







}
