FROM maven:3.8.5-openjdk-17
WORKDIR /app
COPY . .
RUN mvn clean install -DskipTests
VOLUME /app/target
RUN mvn dependency:tree
# CMD mvn spring-boot:run