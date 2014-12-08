package com.example.biblioteka;

import android.support.v7.app.ActionBarActivity;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;

public class Znajdz_ksiazka extends ActionBarActivity 
{

	int id_czytelnika;
	EditText tekst;
	String serwer="";
	
	protected void onCreate(Bundle savedInstanceState) 
	{
		super.onCreate(savedInstanceState);
		Bundle b = getIntent().getExtras();
		id_czytelnika=b.getInt("id_czytelnika");
		serwer=b.getString("serwer");
		setContentView(R.layout.activity_znajdz_ksiazka);
		tekst  = (EditText)findViewById(R.id.editText1);
	}

	public void klik(View v)
    {
		Intent i = new Intent(this,Znajdz_ksiazka2.class);
		i.putExtra("szukane", tekst.getText().toString());
		i.putExtra("serwer", serwer);
		startActivity(i);
    } 

}
