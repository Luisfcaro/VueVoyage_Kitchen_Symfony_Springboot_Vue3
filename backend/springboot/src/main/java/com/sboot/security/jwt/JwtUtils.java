package com.sboot.security.jwt;

import com.sboot.repository.UserRepository;
import com.sboot.security.services.UserDetailsImpl;
import io.jsonwebtoken.Claims;
import io.jsonwebtoken.ExpiredJwtException;
import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.MalformedJwtException;
import io.jsonwebtoken.SignatureAlgorithm;
import io.jsonwebtoken.SignatureException;
import io.jsonwebtoken.UnsupportedJwtException;
import java.util.Date;
import java.util.HashMap;
import org.hibernate.mapping.Map;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.security.core.Authentication;
import org.springframework.stereotype.Component;

@Component
public class JwtUtils {

  @Autowired
  UserRepository userRepository;

  private static final Logger logger = LoggerFactory.getLogger(JwtUtils.class);

  @Value("${spring.app.jwtSecret}")
  private String jwtSecret;

  @Value("${spring.app.jwtExpirationMs}")
  private int jwtExpirationMs;

  public String generateJwtToken(Authentication authentication, String RT) {
    UserDetailsImpl userPrincipal = (UserDetailsImpl) authentication.getPrincipal();

    return Jwts
      .builder()
      .setSubject((userPrincipal.getUsername()))
      .claim("RT", RT)
      .setIssuedAt(new Date())
      .setExpiration(new Date((new Date()).getTime() + jwtExpirationMs))
      .signWith(SignatureAlgorithm.HS512, jwtSecret)
      .compact();
  }

  public String getUserNameFromJwtToken(String token) {
    return Jwts
      .parser()
      .setSigningKey(jwtSecret)
      .parseClaimsJws(token)
      .getBody()
      .getSubject();
  }

  // public boolean validateJwtToken(String authToken) {
  //   try {
  //     Jwts.parser().setSigningKey(jwtSecret).parseClaimsJws(authToken);
  //     return true;
  //   } catch (SignatureException e) {
  //     logger.error("Invalid JWT signature: {}", e.getMessage());
  //   } catch (MalformedJwtException e) {
  //     logger.error("Invalid JWT token: {}", e.getMessage());
  //   } catch (ExpiredJwtException e) {
  //     logger.error("JWT token is expired: {}", e.getMessage());
  //   } catch (UnsupportedJwtException e) {
  //     logger.error("JWT token is unsupported: {}", e.getMessage());
  //   } catch (IllegalArgumentException e) {
  //     logger.error("JWT claims string is empty: {}", e.getMessage());
  //   }

  //   return false;
  // }

  public boolean validateJwtToken(String authToken) {
    try {
      Claims claims = Jwts
        .parser()
        .setSigningKey(jwtSecret)
        .parseClaimsJws(authToken)
        .getBody();
      String username = claims.getSubject();
      String rtFromToken = (String) claims.get("RT");

      // Obtener el valor RT de la base de datos
      String rtFromDatabase = userRepository.findRTByUsername(username);

      if (rtFromToken != null && rtFromToken.equals(rtFromDatabase)) {
        return true;
      } else {
        logger.error("RT mismatch between token and database");
      }
    } catch (SignatureException e) {
      logger.error("Invalid JWT signature: {}", e.getMessage());
    } catch (MalformedJwtException e) {
      logger.error("Invalid JWT token: {}", e.getMessage());
    } catch (ExpiredJwtException e) {
      logger.error("JWT token is expired: {}", e.getMessage());
    } catch (UnsupportedJwtException e) {
      logger.error("JWT token is unsupported: {}", e.getMessage());
    } catch (IllegalArgumentException e) {
      logger.error("JWT claims string is empty: {}", e.getMessage());
    }

    return false;
  }
}
