package com.example.biblioteka;

import android.support.v7.app.ActionBarActivity;
import android.view.View;
import android.widget.TextView;
import android.content.Intent;
import android.os.Bundle;

public class Glowna extends ActionBarActivity 
{

	TextView tekst;
	int id_czytelnika;
	String serwer="";
	
	@Override
	protected void onCreate(Bundle savedInstanceState) 
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_glowna);
		
		tekst = (TextView)findViewById(R.id.textView1);
		Bundle b = getIntent().getExtras();
		serwer=b.getString("serwer");
		String odbior=b.getString("zmienna");
		id_czytelnika=b.getInt("id_czytelnika");
		tekst.setText("Witaj "+odbior);		

	}

	public void klik1(View v)
    {
		Intent i = new Intent(this,Wypozyczenia.class);
		i.putExtra("id_czytelnika", id_czytelnika);
		i.putExtra("serwer", serwer);
		startActivity(i);
    } 
	
	
	public void klik2(View v)
    {
		Intent i = new Intent(this,Znajdz_ksiazka.class);
		i.putExtra("id_czytelnika", id_czytelnika);
		i.putExtra("serwer", serwer);
		startActivity(i);
		
    
    } 
	
	public void klik3(View v)
    {
		Intent i = new Intent(this,Przegladaj_ksiazka.class);
		i.putExtra("id_czytelnika", id_czytelnika);
		i.putExtra("serwer", serwer);
		startActivity(i);
		
    
    } 
	public void klik5(View v)
    {
		this.finish();
		
    
    } 

}
