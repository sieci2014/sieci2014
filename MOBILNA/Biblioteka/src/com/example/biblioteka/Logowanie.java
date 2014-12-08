package com.example.biblioteka;

import java.io.UnsupportedEncodingException;
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Formatter;

import android.support.v7.app.ActionBarActivity;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import android.annotation.SuppressLint;
import android.annotation.TargetApi;
import android.content.Intent;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.StrictMode;

@SuppressLint("NewApi") @TargetApi(Build.VERSION_CODES.GINGERBREAD) 
public class Logowanie extends ActionBarActivity 
{

	
	
 EditText email;
 EditText haslo; 
 TextView blad;
 String serwer = "jdbc:mysql://192.168.2.2/u694572259_sieci";
 int id_czytelnika;

    @SuppressLint("NewApi") @Override
    protected void onCreate(Bundle savedInstanceState) 
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_logowanie);
        blad = (TextView)this.findViewById(R.id.ddd);
        blad.setTextColor(Color.RED);
        blad.setVisibility(TextView.INVISIBLE);
        if (android.os.Build.VERSION.SDK_INT > 9) 
        {
        StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
        StrictMode.setThreadPolicy(policy);
        } 
    }

    
    private class Watek extends AsyncTask<Void,Void,Void>
    {
    	String tekst="Witaj, zaloguj siê...";
    	
    	protected void onPreExecute()
    	{
    Toast.makeText(getApplicationContext(),"Trwa logowanie, czekaj...",Toast.LENGTH_SHORT).show(); 	

    	}

    	protected Void doInBackground(Void... params)
    	{
    		try {
				tekst=polacz();
			} catch (SQLException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}	
    	return null;
    	}
    	
    	protected void onPostExecute(Void result)
    	{
    	blad.setText(tekst);
        blad.setVisibility(TextView.VISIBLE);
    	}

    }
    
    

    public void klik(View v)
    {
    new Watek().execute();
    } 

	///////////////////////////funkcja od MYSQL
	public String polacz() throws SQLException
	{
	String url = serwer;
	String user = "root";
	String pass = ""; 
	email = (EditText)this.findViewById(R.id.editText1);
	haslo = (EditText)this.findViewById(R.id.editText2);
	
	try {
	Class.forName("com.mysql.jdbc.Driver").newInstance();
	Connection con = DriverManager.getConnection(url, user, pass);
	System.out.println("Database connection success\n");
	
	String zapytanie = "SELECT * FROM uzytkownik WHERE Login='"+email.getText().toString()+"'";
	Statement stat = con.createStatement();
	ResultSet result = stat.executeQuery(zapytanie);
	
	System.out.println("Database connection success\n");
	String zwrot="";
	String zwrot_imie = null;
	while(result.next()) { 
	zwrot = result.getString("Haslo");
	zwrot_imie = result.getString("imie");
	id_czytelnika=result.getInt("ID");
	}
	
	if(zwrot.equals("") || !odhasz2(haslo.getText().toString()).equals(zwrot))
	{
	return "B³êdny login lub has³o...";
	}
	else
	{
	Intent i = new Intent(this,Glowna.class);
	i.putExtra("zmienna", zwrot_imie);
	i.putExtra("id_czytelnika", id_czytelnika);
	i.putExtra("serwer", serwer);
	startActivity(i);
	this.finish();
	}
	
	
	}catch(Exception e) 
	{
	e.printStackTrace();
	}
	return "";
	
	}
	
	//funkcja rozhaszuj¹ca ;p
	public String odhasz2(String password)
	{
	String sha1 = "";
	try
	{
	MessageDigest crypt = MessageDigest.getInstance("SHA-1");
	crypt.reset();
	crypt.update(password.getBytes("UTF-8"));
	sha1 = byteToHex(crypt.digest());
	}
	catch(NoSuchAlgorithmException e)
	{
	e.printStackTrace();
	}
	catch(UnsupportedEncodingException e)
	{
	e.printStackTrace();
	}
	return sha1;
	} 
	
	private String byteToHex(final byte[] hash)
	{
	Formatter formatter = new Formatter();
	for (byte b : hash)
	{
	formatter.format("%02x", b);
	}
	String result = formatter.toString();
	formatter.close();
	return result;
	}    
	    
    
    
   
}
