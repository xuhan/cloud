import java.net.*;
import java.io.*;

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
			data = printUsage();             
			out.writeUTF(data);
		}catch (EOFException e){System.out.println("EOF:"+e.getMessage());
		} catch(IOException e) {System.out.println("readline:"+e.getMessage());
		} finally{ try {clientSocket.close();}catch (IOException e){/*close failed*/}}
		

	}



private static String printUsage() {
  OperatingSystemMXBean operatingSystemMXBean = ManagementFactory.getOperatingSystemMXBean();
  DateFormat dateFormat = new SimpleDateFormat("yyyy/MM/dd HH:mm:ss");
        Date date = new Date();
        String data = dateFormat.format(date)+"\n";  

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
}
