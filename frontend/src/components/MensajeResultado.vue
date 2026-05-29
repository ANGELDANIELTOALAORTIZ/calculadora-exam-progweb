<template>
  <div>
    <div v-if="error" class="error">❌ {{ error }}</div>
    <div v-if="resultado !== null && !error" class="resultado">
      ✅ Resultado: {{ resultado }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    error: String,
    resultado: [Number, String]
  }
}
</script>