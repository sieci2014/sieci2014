package com.example.biblioteka;



import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;

import java.util.ArrayList;
import java.util.List;

import android.support.v7.app.ActionBarActivity;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.widget.ProgressBar;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

public class Wypozyczenia extends ActionBarActivity 
{

	ProgressBar b1;
	TableLayout tab1;
	int id_czytelnika;
	String serwer="";
	protected void onCreate(Bundle savedInstanceState) 
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_wypozyczenia);
		
		Bundle b = getIntent().getExtras();
		id_czytelnika=b.getInt("id_czytelnika");
		serwer=b.getString("serwer");
		tab1 = (TableLayout) findViewById(R.id.maintable);
		b1 = (ProgressBar) findViewById(R.id.progressBar1);
		
		
		   new Watek().execute();
		
	}
	
	
	public class tabelka
	{
		
	tabelka()
	{
	id=0;
	tyt="";
	data_wyp="";
	data_odd="";
			
	}
		
	tabelka(int a, String b, String c, String d)
	{
	id=a;
	tyt=b;
	data_wyp=c;
	data_odd=d;
			
	}
	
	int id;
	String tyt;
	String data_wyp;
	String data_odd;
	}
	
	
	List<tabelka> lista = new ArrayList<tabelka>();
	
	
	
	
	private class Watek extends AsyncTask<Void,Void,Void>
    {
    	    	
    	protected void onPreExecute()
    	{
    		b1.setVisibility(ProgressBar.VISIBLE);	
    	}

    	protected Void doInBackground(Void... params)
    	{
    		try {
				polacz();
			} catch (SQLException e) {
				e.printStackTrace();
			}	
    	return null;
    	}
    	
    	protected void onPostExecute(Void result)
    	{
    		for(int k=0; k<lista.size(); k++)
    		{
    		update(Integer.toString(lista.get(k).id),lista.get(k).tyt, lista.get(k).data_wyp, lista.get(k).data_odd) ;    			
    		}
    		
    		
    		b1.setVisibility(ProgressBar.INVISIBLE);
    		
    		
    	}

    }
	
	
	private void update(String t1, String t2, String t3, String t4) 
	{
	   TableRow tr = new TableRow(this); 
	   TextView tv1 = new TextView(this);
	   TextView tv2 = new TextView(this);
	   TextView tv3 = new TextView(this);
	   TextView tv4 = new TextView(this);
	   
	   
	   tv1.setText(t1);
	   tv2.setText(t2);
	   tv3.setText(t3);
	   tv4.setText(t4);
	   tv1.setTextColor(Color.BLACK);
	   tv2.setTextColor(Color.BLACK);
	   tv3.setTextColor(Color.BLACK);
	   tv4.setTextColor(Color.BLACK);
	   
	   
	   tv1.setWidth(100);
	   tv2.setWidth(120);
	   tv3.setWidth(220);
	   tv4.setWidth(200);
	   
	  
       tr.addView(tv1);
       tr.addView(tv2);
       tr.addView(tv3);
       tr.addView(tv4);
       
       tr.setBackgroundColor(Color.WHITE);
       
       
        tab1.addView(tr);
	}
	
		
	
	//WCZYTYWANIE DANYCH 
	public String polacz() throws SQLException
	{
	String url = serwer;
	String user = "root";
	String pass = ""; 
	
	
	try {
	Class.forName("com.mysql.jdbc.Driver").newInstance();
	Connection con = DriverManager.getConnection(url, user, pass);
	System.out.println("Database connection success\n");
	

	
	String zapytanie = 	"SELECT zk.ID_ks, zk.ID_zam, zk.Data_zam, zk.Data_do_kiedy FROM Zamowienie_Ksiazka zk, Zamowienie z WHERE z.ID="+id_czytelnika+" AND zk.ID_zam=z.ID_zam";
	Statement stat = con.createStatement();
	ResultSet result = stat.executeQuery(zapytanie);
	
	
	while(result.next()) 
	{
	int id = 0;
	id= result.getInt("ID_zam");
	int ksiazka = 0;
	ksiazka = result.getInt("ID_ks");
	String data_wyp =  result.getString("Data_zam");
	data_wyp = data_wyp.substring(0, Math.min(data_wyp.length(), 10));
	String data_odd = result.getString("Data_do_kiedy");
	data_odd = data_odd.substring(0, Math.min(data_odd.length(), 10));
	String tytul="";
	
	if(ksiazka!=0)
	{
		tytul = polacz2("ksiazka", ksiazka);
	}
	
		
	//lista
	lista.add(new tabelka(id, tytul, data_wyp, data_odd));	
	}
	
	
	
	}catch(Exception e) 
	{
	e.printStackTrace();
	}
	return "";
	
	}

	
	
	
	public String polacz2(String skad, int iddqd) throws SQLException
	{
	String url = serwer;
	String user = "root";
	String pass = ""; 
	String tytul = null;
	
	try {
	Class.forName("com.mysql.jdbc.Driver").newInstance();
	Connection con = DriverManager.getConnection(url, user, pass);
	
	String zapytanie = "SELECT * FROM "+skad+" WHERE ID_ks='"+iddqd+"'";
	Statement stat = con.createStatement();
	ResultSet result = stat.executeQuery(zapytanie);
	
	
	while(result.next()) 
	{
	tytul= result.getString("Tytul_ks");
	}

	
	}catch(Exception e) 
	{
	e.printStackTrace();
	}
	return tytul;
	
	}
	
	
	
	
	

}
