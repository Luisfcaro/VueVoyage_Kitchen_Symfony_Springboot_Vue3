package com.sboot.repository;

import com.sboot.model.Bookings;
import java.util.List;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

@Repository
public interface BookingsRepository extends JpaRepository<Bookings, Long> {
  @Query(
    "SELECT b FROM Bookings b WHERE b.user.id = :userId AND b.state <> 'Cancelada'"
  )
  List<Bookings> findByUserId(@Param("userId") Long userId);
}
