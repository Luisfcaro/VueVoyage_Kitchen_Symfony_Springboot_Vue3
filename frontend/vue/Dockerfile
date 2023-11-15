# Utiliza una imagen base que contenga Node.js
FROM node:14

# Establece el directorio de trabajo en el contenedor
WORKDIR /app

# Copia el archivo package.json y package-lock.json al directorio de trabajo
COPY package*.json ./

# Instala las dependencias del proyecto
RUN npm install

# Copia el resto de los archivos de la aplicación al contenedor
COPY . .

# Expone el puerto en el que se ejecutará la aplicación Vue
EXPOSE 7000

# Inicia la aplicación Vite
CMD ["npm", "run", "dev"]