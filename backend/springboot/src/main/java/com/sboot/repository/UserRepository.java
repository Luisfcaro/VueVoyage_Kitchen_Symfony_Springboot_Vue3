package com.sboot.repository;

import com.sboot.model.User;
import java.util.Optional;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;

public interface UserRepository extends JpaRepository<User, Long> {
  Optional<User> findByUsername(String username);

  @Query(
    value = "SELECT COUNT(*) FROM users WHERE username = :username",
    nativeQuery = true
  )
  Integer existsByUsername(@Param("username") String username);

  @Query(
    value = "SELECT COUNT(*) FROM users WHERE email = :email",
    nativeQuery = true
  )
  Integer existsByEmail(@Param("email") String email);

  @Query(
    value = "SELECT u.RT FROM users u WHERE u.username = :username",
    nativeQuery = true
  )
  String findRTByUsername(@Param("username") String username);
}
