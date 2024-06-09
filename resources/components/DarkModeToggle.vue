<template>
    <label class="toggle-switch">
      <input type="checkbox" @change="toggleDarkMode" :checked="isDark">
      <span class="slider"></span>
    </label>
  </template>
  <script>
  import { useDark } from '@vueuse/core'
  
  export default {
    setup() {
      const isDark = useDark({
        storageKey: 'vueuse-color-scheme', // Clave en localStorage
        attribute: 'data-theme', // Atributo en el HTML
      })
  
      // Define la función toggleDarkMode
      const toggleDarkMode = () => {
        isDark.value = !isDark.value // Alterna el valor de isDark
      }
  
      return { isDark, toggleDarkMode }
    }
  }
  </script>
  
  <style scoped>
  .toggle-switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }
  
  .toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }
  
  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgb(75, 44, 124);
    transition: .4s;
    border-radius: 34px;
  }
  
  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
  }
  
  input:checked + .slider {
    background-color: rgb(0,17,69);
  }
  
  input:checked + .slider:before {
    transform: translateX(26px);
  }
  
  .slider:after {
    content: '☀️';
    position: absolute;
    right: 10px;
    top: 6px;
    font-size: 16px;
  }
  
  input:checked + .slider:after {
    content: '🌙';
    left: 10px;
    right: auto;
  }
  </style>