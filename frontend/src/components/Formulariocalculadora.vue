<template>
  <div>
    <h2>Calculadora</h2>
    <label>Operador 1</label>
    <input type="text" v-model="op1" placeholder="Ej. 10" />

    <label>Operador 2</label>
    <input type="text" v-model="op2" placeholder="Ej. 5" />

    <label>Operación</label>
    <select v-model="op">
      <option value="">-- Selecciona --</option>
      <option value="suma">Suma</option>
      <option value="resta">Resta</option>
      <option value="multiplicacion">Multiplicación</option>
      <option value="division">División</option>
    </select>

    <button @click="enviar">Calcular</button>
  </div>
</template>

<script>
export default {
  emits: ['calcular'],
  data() {
    return {
      op1: '',
      op2: '',
      op: ''
    }
  },
  methods: {
    enviar() {
      if (!this.op1 || !this.op2 || !this.op) {
        alert('Por favor completa todos los campos.');
        return;
      }
      this.$emit('calcular', {
        op1: this.op1,
        op2: this.op2,
        op: this.op
      });
    }
  }
}
</script>