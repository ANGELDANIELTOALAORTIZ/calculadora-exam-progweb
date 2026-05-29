<template>
  <div class="formulario">
    <FormularioCalculadora @calcular="procesarCalculo" />
    <MensajeResultado :error="error" :resultado="resultado" />
  </div>
</template>

<script>
import FormularioCalculadora from './components/FormularioCalculadora.vue'
import MensajeResultado from './components/MensajeResultado.vue'

export default {
  components: { FormularioCalculadora, MensajeResultado },
  data() {
    return {
      error: '',
      resultado: null
    }
  },
  methods: {
    async procesarCalculo(datos) {
      this.error = '';
      this.resultado = null;

      try {
        const respuesta = await fetch('./calculadora.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(datos)
        });

        const data = await respuesta.json();
        if (data.ok) {
          this.resultado = data.resultado;
        } else {
          this.error = data.error;
        }
      } catch (e) {
        this.error = 'Error de comunicación con el servidor.';
      }
    }
  }
}
</script>