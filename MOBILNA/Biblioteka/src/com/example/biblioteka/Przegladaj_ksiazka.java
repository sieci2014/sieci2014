package com.example.biblioteka;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;

import com.mysql.jdbc.PreparedStatement;

import android.support.v7.app.ActionBarActivity;
import android.annotation.SuppressLint;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.ProgressBar;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

public class Przegladaj_ksiazka extends ActionBarActivity 
{

	ProgressBar b1;
	TableLayout tab1;
	int id_czytelnika;
	String serwer="";
	
	protected void onCreate(Bundle savedInstanceState) 
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_przegladaj_ksiazka);
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
		tytul="";
		autor="";
		wydawnictwo="";
		rok_wydania="";
		dostepny="";
	}
		
	tabelka(String a, String b, String c, String d, String e, Button f)
	{
	tytul=a;
	autor=b;
	wydawnictwo=c;
	rok_wydania=d;
	guzik=f;
	dostepny=e;
	}
	
	String tytul;
	String autor;
	String wydawnictwo;
	String rok_wydania;
	String id_oddzialu;
	String dostepny;
	Button guzik;
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
    			if(k%2==0)
    			{
    	    	update(lista.get(k).tytul, lista.get(k).autor, lista.get(k).wydawnictwo, lista.get(k).rok_wydania, lista.get(k).dostepny, lista.get(k).guzik, true) ;    			
    			}
    			else
    			{
        	    update(lista.get(k).tytul, lista.get(k).autor, lista.get(k).wydawnictwo, lista.get(k).rok_wydania, lista.get(k).dostepny, lista.get(k).guzik, false) ;    			  				
    			}
    		}
    		
    		
    		b1.setVisibility(ProgressBar.INVISIBLE);
    		
    		
    	}

    }
	
	
	private void update(String t1, String t2, String t3, String t4, String t5, Button t6, boolean kolor) 
	{
	   TableRow tr = new TableRow(this); 
	   TextView tv1 = new TextView(this);
	   TextView tv2 = new TextView(this);
	   TextView tv3 = new TextView(this);
	   TextView tv4 = new TextView(this);
	   TextView tv5 = new TextView(this);
	   
	   tv1.setText(t1);
	   tv2.setText(t2);
	   tv3.setText(t3);
	   tv4.setText(t4);
	   tv5.setText(t5);
	   tv1.setTextColor(Color.BLACK);
	   tv2.setTextColor(Color.BLACK);
	   tv3.setTextColor(Color.BLACK);
	   tv4.setTextColor(Color.BLACK);
	   tv5.setTextColor(Color.BLACK);
	   
	   
	   tv1.setWidth(100);
	   tv2.setWidth(115);
	   tv3.setWidth(100);
	   tv4.setWidth(100);
	   tv5.setWidth(100);
	   
	  
       tr.addView(tv1);
       tr.addView(tv2);
       tr.addView(tv3);
       tr.addView(tv4);
       tr.addView(tv5);

       if(t5=="Dostêpna")
       {
       tr.addView(t6);
       }
       
       if(kolor)
       {
       tr.setBackgroundColor(Color.WHITE);
       }
       else
       {
       tr.setBackgroundColor(Color.GRAY);    	   
       }
       
       
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
		
		String zapytanie = "SELECT * FROM ksiazka k, autor a WHERE a.ID_autor=k.ID_autor";
		Statement stat = con.createStatement();
		ResultSet result = stat.executeQuery(zapytanie);
		
		while(result.next()) 
		{
		int id = result.getInt("ID_ks");
		String tytul = result.getString("Tytul_ks");
		String autor = result.getString("Nazwisko_aut");
		String wydawnictwo = result.getString("Wyd_ks");
		int rok_wydania = result.getInt("Rok_wyd");
		int dostepny = result.getInt("status");
		String dostepny2=""	;
		if(dostepny == 0)
		{
		dostepny2="Dostêpna";
		}
		if(dostepny == 1)
		{
		dostepny2="Wypo¿yczona";
		}
		if(dostepny == 2)
		{
		dostepny2="Rezerwacja";
		}
		
		
		Button myButton = new Button(this);
		if(dostepny==0)
		{
		myButton.setText("Rezerw.");
		myButton.setOnClickListener(rezerwacja);
		myButton.setTag(id);
		}
		
		
		
		String rokk = "       "+rok_wydania;
		//lista
		lista.add(new tabelka(tytul, autor, wydawnictwo, rokk, dostepny2, myButton));	
		}
		
		
		
		}catch(Exception e) 
		{
		e.printStackTrace();
		}
		return "";
		
		}

		
			
		OnClickListener rezerwacja = new OnClickListener()
		{
			    @SuppressLint("NewApi") @Override
			    public void onClick(View v) 
			    {
			    int ID_KSIAZKI = (Integer) v.getTag();
			    
			    
		        
			    try {
					polacz2(ID_KSIAZKI);
					 recreate();
				} catch (SQLException e) {
					e.printStackTrace();
				}
			    
			    
			    
			    }

		};
		
		public void polacz2(int ksiazka) throws SQLException
		{
		String url = serwer;
		String user = "root";
		String pass = ""; 
		PreparedStatement preparedStatement = null;
		
		try {
		Class.forName("com.mysql.jdbc.Driver").newInstance();
		Connection con = DriverManager.getConnection(url, user, pass);
		System.out.println("Database connection success\n");
		
		String zapytanie = "INSERT INTO `zamowienie`(`ID_zam`, `ID`) VALUES (NULL,"+id_czytelnika+")";
		preparedStatement = (PreparedStatement) con.prepareStatement(zapytanie);
	    preparedStatement.executeUpdate();
		
		polacz3(ksiazka);
		
		}catch(Exception e) 
		{
		e.printStackTrace();
	    Toast.makeText(getApplicationContext(),"B³¹d1 ;/",Toast.LENGTH_SHORT).show(); 	

		}
	
		
		}
		
		public void polacz3(int ksiazka) throws SQLException
		{
		String url = serwer;
		String user = "root";
		String pass = ""; 
		
		
		try {
		Class.forName("com.mysql.jdbc.Driver").newInstance();
		Connection con = DriverManager.getConnection(url, user, pass);
		System.out.println("Database connection success\n");
		 SimpleDateFormat teraz = new SimpleDateFormat("yyyy-MM-dd");
	     
     	 Calendar cal = Calendar.getInstance(); 
		 cal.add(Calendar.MONTH, 1);
		 java.util.Date miesiac = cal.getTime();


		 
		String t =  teraz.format(new Date());
		
		String m = teraz.format(miesiac);
		
		System.out.println("TERAZ: "+t);
		System.out.println("potem: "+m);
		
		
		String zapytanie = "INSERT INTO `zamowienie_ksiazka`(`ID_ks`, `ID_zam`, `Data_zam`, `Data_do_kiedy`) VALUES ('"+ksiazka+"',NULL,'"+t+"','"+m+"')";
		
		System.out.println(zapytanie);
		PreparedStatement preparedStatement = null;
		preparedStatement = (PreparedStatement) con.prepareStatement(zapytanie);
	    preparedStatement.executeUpdate();
		
			
		polacz4(ksiazka);
		
		}catch(Exception e) 
		{
		e.printStackTrace();
	    Toast.makeText(getApplicationContext(),"B³¹d 2 ;/",Toast.LENGTH_SHORT).show(); 	

		}
	
		
		}
		
		public void polacz4(int ksiazka) throws SQLException
		{
		String url = serwer;
		String user = "root";
		String pass = ""; 
		
		
		try {
		Class.forName("com.mysql.jdbc.Driver").newInstance();
		Connection con = DriverManager.getConnection(url, user, pass);
		System.out.println("Database connection success\n");
		
		String zapytanie = "UPDATE Ksiazka SET status=2 WHERE ID_ks="+ksiazka;
		
		PreparedStatement preparedStatement = null;
		preparedStatement = (PreparedStatement) con.prepareStatement(zapytanie);
	    preparedStatement.executeUpdate();
	    
	    Toast.makeText(getApplicationContext(),"Zarezerwowano ;)",Toast.LENGTH_SHORT).show(); 	

		}catch(Exception e) 
		{
		e.printStackTrace();
	    Toast.makeText(getApplicationContext(),"B³¹d 3 ;/",Toast.LENGTH_SHORT).show(); 	

		}
	
		
		}
		
		
		
}
