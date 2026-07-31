import os

print("Generando los archivos del desafío...")

archivos = {
    "MainActivity.kt": r"""package com.example.propinas

import android.os.Bundle
import android.view.View
import android.widget.*
import androidx.appcompat.app.AppCompatActivity

class MainActivity : AppCompatActivity() {

    private lateinit var etMonto: EditText
    private lateinit var etPersonas: EditText
    private lateinit var rgPropina: RadioGroup
    private lateinit var etPropinaPersonalizada: EditText
    private lateinit var switchIva: Switch
    private lateinit var btnCalcular: Button
    private lateinit var btnLimpiar: Button
    private lateinit var tvResultado: TextView

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_main)

        etMonto = findViewById(R.id.etMonto)
        etPersonas = findViewById(R.id.etPersonas)
        rgPropina = findViewById(R.id.rgPropina)
        etPropinaPersonalizada = findViewById(R.id.etPropinaPersonalizada)
        switchIva = findViewById(R.id.switchIva)
        btnCalcular = findViewById(R.id.btnCalcular)
        btnLimpiar = findViewById(R.id.btnLimpiar)
        tvResultado = findViewById(R.id.tvResultado)

        rgPropina.setOnCheckedChangeListener { _, checkedId ->
            if (checkedId == R.id.rbOtro) {
                // Mostrar campo para propina manual
                etPropinaPersonalizada.visibility = View.VISIBLE
            } else {
                etPropinaPersonalizada.visibility = View.GONE
                etPropinaPersonalizada.text.clear()
            }
        }

        btnCalcular.setOnClickListener { calcular() }
        btnLimpiar.setOnClickListener { limpiar() }
    }

    private fun calcular() {
        val montoStr = etMonto.text.toString()
        val personasStr = etPersonas.text.toString()

        // Validaciones de vacíos
        if (montoStr.isEmpty()) {
            etMonto.error = getString(R.string.error_vacio)
            return
        }
        if (personasStr.isEmpty()) {
            etPersonas.error = getString(R.string.error_vacio)
            return
        }

        val monto = montoStr.toDoubleOrNull() ?: 0.0
        val personas = personasStr.toIntOrNull() ?: 0

        // Validaciones matemáticas
        if (monto <= 0) {
            etMonto.error = getString(R.string.error_invalido)
            return
        }
        if (personas <= 0) {
            etPersonas.error = getString(R.string.error_invalido)
            return
        }

        // Obtener el porcentaje
        var porcentaje = 0.0
        when (rgPropina.checkedRadioButtonId) {
            R.id.rb10 -> porcentaje = 10.0
            R.id.rb15 -> porcentaje = 15.0
            R.id.rb20 -> porcentaje = 20.0
            R.id.rbOtro -> {
                val customPropina = etPropinaPersonalizada.text.toString().toDoubleOrNull()
                if (customPropina == null || customPropina < 0) {
                    etPropinaPersonalizada.error = getString(R.string.error_invalido)
                    return
                }
                porcentaje = customPropina
            }
        }

        // Matemáticas finales
        val iva = if (switchIva.isChecked) monto * 0.16 else 0.0
        val propina = monto * (porcentaje / 100)
        val total = monto + iva + propina
        val porPersona = total / personas

        // Mostramos formateado
        tvResultado.text = getString(R.string.resultado_txt, propina, total, porPersona)
    }

    private fun limpiar() {
        etMonto.text.clear()
        etPersonas.text.clear()
        rgPropina.check(R.id.rb10) // Regresa al 10% por defecto
        switchIva.isChecked = false
        tvResultado.text = ""
        etMonto.requestFocus()
    }
}
""",
    "colors.xml": r"""<?xml version="1.0" encoding="utf-8"?>
<resources>
    <color name="primary">#6750A4</color>
    <color name="header_bg">#64D8CB</color>
    <color name="black">#000000</color>
    <color name="white">#FFFFFF</color>
</resources>
""",
    "dimens.xml": r"""<?xml version="1.0" encoding="utf-8"?>
<resources>
    <dimen name="margin_standard">16dp</dimen>
    <dimen name="margin_small">8dp</dimen>
    <dimen name="text_title">22sp</dimen>
    <dimen name="text_regular">16sp</dimen>
    <dimen name="button_radius">20dp</dimen>
</resources>
""",
    "strings.xml": r"""<?xml version="1.0" encoding="utf-8"?>
<resources>
    <string name="app_name">Calculadora Propinas</string>
    <string name="header_text">Calculadora de Propinas para\ngrupos tacaños</string>
    <string name="label_monto">Monto Total</string>
    <string name="label_personas">Número de Personas</string>
    <string name="label_propina">Propina</string>
    <string name="propina_10">10%</string>
    <string name="propina_15">15%</string>
    <string name="propina_20">20%</string>
    <string name="propina_otro">Otro</string>
    <string name="label_iva">Incluir IVA (16%)</string>
    <string name="btn_calcular">Calcular</string>
    <string name="btn_limpiar">Limpiar</string>
    <string name="error_vacio">Campo requerido</string>
    <string name="error_invalido">Valor inválido</string>
    <string name="resultado_txt">Propina: $%.2f\nTotal: $%.2f\nImporte por persona: $%.2f</string>
    <string name="hint_otro">%</string>
</resources>
""",
    "activity_main.xml": r"""<?xml version="1.0" encoding="utf-8"?>
<ScrollView xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:padding="@dimen/margin_standard">

    <LinearLayout
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:orientation="vertical">

        <TextView
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:background="@color/header_bg"
            android:padding="@dimen/margin_standard"
            android:text="@string/header_text"
            android:textAlignment="center"
            android:textColor="@color/black"
            android:textSize="@dimen/text_title"
            android:textStyle="bold" />

        <TextView
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            android:layout_marginTop="@dimen/margin_standard"
            android:text="@string/label_monto"
            android:textSize="@dimen/text_regular" />

        <EditText
            android:id="@+id/etMonto"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:hint="@string/label_monto"
            android:inputType="numberDecimal" />

        <TextView
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            android:layout_marginTop="@dimen/margin_standard"
            android:text="@string/label_personas"
            android:textSize="@dimen/text_regular" />

        <EditText
            android:id="@+id/etPersonas"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:hint="@string/label_personas"
            android:inputType="number" />

        <TextView
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            android:layout_marginTop="@dimen/margin_standard"
            android:text="@string/label_propina"
            android:textSize="@dimen/text_regular" />

        <LinearLayout
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:orientation="horizontal"
            android:gravity="center_vertical">

            <RadioGroup
                android:id="@+id/rgPropina"
                android:layout_width="wrap_content"
                android:layout_height="wrap_content"
                android:orientation="horizontal">

                <RadioButton
                    android:id="@+id/rb10"
                    android:layout_width="wrap_content"
                    android:layout_height="wrap_content"
                    android:checked="true"
                    android:text="@string/propina_10" />

                <RadioButton
                    android:id="@+id/rb15"
                    android:layout_width="wrap_content"
                    android:layout_height="wrap_content"
                    android:text="@string/propina_15" />

                <RadioButton
                    android:id="@+id/rb20"
                    android:layout_width="wrap_content"
                    android:layout_height="wrap_content"
                    android:text="@string/propina_20" />

                <RadioButton
                    android:id="@+id/rbOtro"
                    android:layout_width="wrap_content"
                    android:layout_height="wrap_content"
                    android:text="@string/propina_otro" />
            </RadioGroup>

            <EditText
                android:id="@+id/etPropinaPersonalizada"
                android:layout_width="60dp"
                android:layout_height="wrap_content"
                android:layout_marginStart="@dimen/margin_small"
                android:hint="@string/hint_otro"
                android:inputType="numberDecimal"
                android:visibility="gone" />
        </LinearLayout>

        <Switch
            android:id="@+id/switchIva"
            android:layout_width="wrap_content"
            android:layout_height="wrap_content"
            android:layout_marginTop="@dimen/margin_standard"
            android:text="@string/label_iva" />

        <LinearLayout
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="@dimen/margin_standard"
            android:orientation="horizontal">

            <Button
                android:id="@+id/btnCalcular"
                android:layout_width="0dp"
                android:layout_height="wrap_content"
                android:layout_marginEnd="@dimen/margin_small"
                android:layout_weight="1"
                android:backgroundTint="@color/primary"
                android:text="@string/btn_calcular"
                android:textColor="@color/white" />

            <Button
                android:id="@+id/btnLimpiar"
                android:layout_width="0dp"
                android:layout_height="wrap_content"
                android:layout_marginStart="@dimen/margin_small"
                android:layout_weight="1"
                android:backgroundTint="@color/primary"
                android:text="@string/btn_limpiar"
                android:textColor="@color/white" />
        </LinearLayout>

        <TextView
            android:id="@+id/tvResultado"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:layout_marginTop="@dimen/margin_standard"
            android:textSize="@dimen/text_regular"
            android:textStyle="bold" />

    </LinearLayout>
</ScrollView>
"""
}

for nombre, contenido in archivos.items():
    with open(nombre, "w", encoding="utf-8") as f:
        f.write(contenido.strip())
    print(f"✅ Archivo creado: {nombre}")

print("\n¡Todo chivo! Archivos listos. Solo arrastralos a sus carpetas en Android Studio.")