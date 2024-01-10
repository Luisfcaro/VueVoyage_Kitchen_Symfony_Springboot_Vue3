package com.sboot.repository;

import com.sboot.model.Turns;
import java.util.List;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

public interface TurnsRepository extends JpaRepository<Turns, Long> {
  @Query(
    value = "SELECT * FROM turns tu " +
    "WHERE tu.id NOT IN (SELECT id_turn FROM bookings b " +
    "INNER JOIN bookings_tables bt ON bt.id_booking = b.id " +
    "INNER JOIN tables t ON t.id_table = bt.id_table " +
    "WHERE b.id_rest = :rest AND b.date = :date_pick " +
    "GROUP BY id_turn " +
    "HAVING (SUM(t.capacity_table) + :people) > " +
    "(SELECT SUM(t.capacity_table) capacity_rest FROM tables t WHERE t.id_rest = :rest)) " +
    "AND :people <= (SELECT SUM(t.capacity_table) capacity_rest FROM tables t WHERE t.id_rest = :rest)",
    nativeQuery = true
  )
  List<Turns> findTurnsAvaibles(int people, String date_pick, int rest);
}
