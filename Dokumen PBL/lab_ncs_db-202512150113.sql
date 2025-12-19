--
-- PostgreSQL database dump
--

\restrict HAx6DH3dNX9AcK1Q41wm7SKlKsUwH9ddwfSlTZjh1u6GP7s9vbRIaLYiXosYT8t

-- Dumped from database version 15.14
-- Dumped by pg_dump version 15.14

-- Started on 2025-12-15 01:13:36

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 250 (class 1255 OID 20291)
-- Name: sp_calculate_performance_ranking(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_calculate_performance_ranking(p_tahun integer DEFAULT NULL::integer) RETURNS TABLE(id_pengelola integer, nama_pengelola character varying, nid_nip character varying, foto_pengelola character varying, nama_jabatan character varying, c1_penelitian integer, c2_pengabdian integer, n_c1 numeric, n_c2 numeric, total_score numeric, rank integer)
    LANGUAGE plpgsql
    AS $$
DECLARE
    max_c1 INTEGER;
    max_c2 INTEGER;
BEGIN
    -- Hitung max values untuk normalisasi
    IF p_tahun IS NOT NULL THEN
        SELECT GREATEST(1, COALESCE(MAX(cnt), 1)) INTO max_c1
        FROM (
            SELECT COUNT(*) AS cnt
            FROM tbl_penelitian_anggota pa
            JOIN tbl_penelitian pn ON pa.id_penelitian = pn.id_penelitian
            WHERE pn.tahun_penelitian::INTEGER = p_tahun
            GROUP BY pa.id_pengelola
        ) sub;
        
        SELECT GREATEST(1, COALESCE(MAX(cnt), 1)) INTO max_c2
        FROM (
            SELECT COUNT(*) AS cnt
            FROM tbl_pengabdian_anggota pa
            JOIN tbl_pengabdian pg ON pa.id_pengabdian = pg.id_pengabdian
            WHERE pg.tahun_kegiatan::INTEGER = p_tahun
            GROUP BY pa.id_pengelola
        ) sub;
    ELSE
        SELECT GREATEST(1, COALESCE(MAX(cnt), 1)) INTO max_c1
        FROM (
            SELECT COUNT(*) AS cnt
            FROM tbl_penelitian_anggota pa
            GROUP BY pa.id_pengelola
        ) sub;
        
        SELECT GREATEST(1, COALESCE(MAX(cnt), 1)) INTO max_c2
        FROM (
            SELECT COUNT(*) AS cnt
            FROM tbl_pengabdian_anggota pa
            GROUP BY pa.id_pengelola
        ) sub;
    END IF;

    RETURN QUERY
    WITH criteria AS (
        SELECT 
            p.id_pengelola,
            p.nama_pengelola,
            p.nid_nip,
            p.foto_pengelola,
            COALESCE(j.nama_jabatan, '-') AS nama_jabatan,
            COALESCE(
                CASE WHEN p_tahun IS NOT NULL THEN
                    (SELECT COUNT(*)::INTEGER 
                     FROM tbl_penelitian_anggota pa
                     JOIN tbl_penelitian pn ON pa.id_penelitian = pn.id_penelitian
                     WHERE pa.id_pengelola = p.id_pengelola AND pn.tahun_penelitian::INTEGER = p_tahun)
                ELSE
                    (SELECT COUNT(*)::INTEGER FROM tbl_penelitian_anggota pa2 WHERE pa2.id_pengelola = p.id_pengelola)
                END
            , 0) AS c1,
            COALESCE(
                CASE WHEN p_tahun IS NOT NULL THEN
                    (SELECT COUNT(*)::INTEGER 
                     FROM tbl_pengabdian_anggota pa
                     JOIN tbl_pengabdian pg ON pa.id_pengabdian = pg.id_pengabdian
                     WHERE pa.id_pengelola = p.id_pengelola AND pg.tahun_kegiatan::INTEGER = p_tahun)
                ELSE
                    (SELECT COUNT(*)::INTEGER FROM tbl_pengabdian_anggota pa2 WHERE pa2.id_pengelola = p.id_pengelola)
                END
            , 0) AS c2
        FROM tbl_pengelola p
        LEFT JOIN tbl_jabatan j ON p.id_jabatan = j.id_jabatan
    )
    SELECT 
        c.id_pengelola,
        c.nama_pengelola,
        c.nid_nip,
        c.foto_pengelola,
        c.nama_jabatan,
        c.c1 AS c1_penelitian,
        c.c2 AS c2_pengabdian,
        ROUND(c.c1::NUMERIC / max_c1::NUMERIC, 4) AS n_c1,
        ROUND(c.c2::NUMERIC / max_c2::NUMERIC, 4) AS n_c2,
        ROUND((c.c1::NUMERIC / max_c1::NUMERIC * 0.5) + (c.c2::NUMERIC / max_c2::NUMERIC * 0.5), 4) AS total_score,
        ROW_NUMBER() OVER (
            ORDER BY 
                ((c.c1::NUMERIC / max_c1::NUMERIC * 0.5) + (c.c2::NUMERIC / max_c2::NUMERIC * 0.5)) DESC,
                c.nama_pengelola ASC
        )::INTEGER AS rank
    FROM criteria c
    ORDER BY total_score DESC, c.nama_pengelola ASC;
END;
$$;


ALTER FUNCTION public.sp_calculate_performance_ranking(p_tahun integer) OWNER TO postgres;

--
-- TOC entry 251 (class 1255 OID 20292)
-- Name: sp_delete_pengelola_cascade(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_delete_pengelola_cascade(p_id integer) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
BEGIN
    -- Hapus relasi keminatan
    DELETE FROM tbl_pengelola_keminatan WHERE id_pengelola = p_id;
    
    -- Hapus relasi penelitian
    DELETE FROM tbl_penelitian_anggota WHERE id_pengelola = p_id;
    
    -- Hapus relasi pengabdian
    DELETE FROM tbl_pengabdian_anggota WHERE id_pengelola = p_id;
    
    -- Hapus pengelola
    DELETE FROM tbl_pengelola WHERE id_pengelola = p_id;
    
    RETURN TRUE;
END;
$$;


ALTER FUNCTION public.sp_delete_pengelola_cascade(p_id integer) OWNER TO postgres;

--
-- TOC entry 264 (class 1255 OID 20293)
-- Name: sp_find_team_candidates(integer[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_find_team_candidates(p_keminatan_ids integer[]) RETURNS TABLE(id_pengelola integer, nama_pengelola character varying, nid_nip character varying, foto_pengelola character varying, nama_jabatan character varying, keminatan text, keminatan_count integer, match_count integer, workload integer, match_score numeric, final_score numeric, rank integer)
    LANGUAGE plpgsql
    AS $$
DECLARE
    required_count INTEGER;
    current_year INTEGER;
BEGIN
    required_count := array_length(p_keminatan_ids, 1);
    current_year := EXTRACT(YEAR FROM CURRENT_DATE)::INTEGER;
    
    IF required_count IS NULL OR required_count = 0 THEN
        RETURN;
    END IF;
    
    RETURN QUERY
    WITH pengelola_keminatan AS (
        SELECT 
            pk.id_pengelola,
            array_agg(pk.id_keminatan) AS keminatan_ids,
            string_agg(k.nama_keminatan, ', ' ORDER BY k.nama_keminatan) AS keminatan_names,
            COUNT(pk.id_keminatan)::INTEGER AS kem_count
        FROM tbl_pengelola_keminatan pk
        JOIN tbl_keminatan k ON pk.id_keminatan = k.id_keminatan
        GROUP BY pk.id_pengelola
    ),
    pengelola_workload AS (
        SELECT 
            p.id_pengelola,
            (
                COALESCE((
                    SELECT COUNT(*)::INTEGER
                    FROM tbl_penelitian_anggota pa
                    JOIN tbl_penelitian pn ON pa.id_penelitian = pn.id_penelitian
                    WHERE pa.id_pengelola = p.id_pengelola 
                    AND pn.tahun_penelitian::INTEGER = current_year
                ), 0) +
                COALESCE((
                    SELECT COUNT(*)::INTEGER
                    FROM tbl_pengabdian_anggota pa
                    JOIN tbl_pengabdian pg ON pa.id_pengabdian = pg.id_pengabdian
                    WHERE pa.id_pengelola = p.id_pengelola 
                    AND pg.tahun_kegiatan::INTEGER = current_year
                ), 0)
            ) AS total_workload
        FROM tbl_pengelola p
    ),
    scored_candidates AS (
        SELECT 
            p.id_pengelola,
            p.nama_pengelola,
            p.nid_nip,
            p.foto_pengelola,
            COALESCE(j.nama_jabatan, '-') AS nama_jabatan,
            COALESCE(pk.keminatan_names, '-') AS keminatan,
            COALESCE(pk.kem_count, 0) AS keminatan_count,
            COALESCE((
                SELECT COUNT(*)::INTEGER 
                FROM unnest(pk.keminatan_ids) AS kid 
                WHERE kid = ANY(p_keminatan_ids)
            ), 0) AS match_count,
            COALESCE(pw.total_workload, 0) AS workload,
            ROUND(
                (COALESCE((
                    SELECT COUNT(*)::NUMERIC 
                    FROM unnest(pk.keminatan_ids) AS kid 
                    WHERE kid = ANY(p_keminatan_ids)
                ), 0) / required_count::NUMERIC) * 100, 
                2
            ) AS match_score
        FROM tbl_pengelola p
        LEFT JOIN tbl_jabatan j ON p.id_jabatan = j.id_jabatan
        LEFT JOIN pengelola_keminatan pk ON p.id_pengelola = pk.id_pengelola
        LEFT JOIN pengelola_workload pw ON p.id_pengelola = pw.id_pengelola
    )
    SELECT 
        sc.id_pengelola,
        sc.nama_pengelola,
        sc.nid_nip,
        sc.foto_pengelola,
        sc.nama_jabatan,
        sc.keminatan,
        sc.keminatan_count,
        sc.match_count,
        sc.workload,
        sc.match_score,
        GREATEST(0, sc.match_score - CASE WHEN sc.workload > 5 THEN 20 ELSE 0 END)::NUMERIC AS final_score,
        ROW_NUMBER() OVER (
            ORDER BY 
                GREATEST(0, sc.match_score - CASE WHEN sc.workload > 5 THEN 20 ELSE 0 END) DESC,
                sc.nama_pengelola ASC
        )::INTEGER AS rank
    FROM scored_candidates sc
    ORDER BY final_score DESC, sc.nama_pengelola ASC;
END;
$$;


ALTER FUNCTION public.sp_find_team_candidates(p_keminatan_ids integer[]) OWNER TO postgres;

--
-- TOC entry 265 (class 1255 OID 20294)
-- Name: sp_insert_penelitian(json); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_insert_penelitian(p_data json) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_id INTEGER;
    peneliti_id INTEGER;
BEGIN
    -- Insert data utama
    INSERT INTO tbl_penelitian (
        judul_penelitian, 
        tahun_penelitian, 
        deskripsi_singkat, 
        link_publikasi, 
        file_dokumen_pdf, 
        anggota_luar,
        created_at
    ) VALUES (
        p_data->>'judul_penelitian',
        (p_data->>'tahun_penelitian')::INTEGER,
        p_data->>'deskripsi_singkat',
        p_data->>'link_publikasi',
        p_data->>'file_dokumen_pdf',
        p_data->>'anggota_luar',
        NOW()
    ) RETURNING id_penelitian INTO new_id;
    
    -- Insert anggota penelitian
    FOR peneliti_id IN SELECT json_array_elements_text(p_data->'peneliti')::INTEGER
    LOOP
        INSERT INTO tbl_penelitian_anggota (id_penelitian, id_pengelola)
        VALUES (new_id, peneliti_id);
    END LOOP;
    
    RETURN new_id;
END;
$$;


ALTER FUNCTION public.sp_insert_penelitian(p_data json) OWNER TO postgres;

--
-- TOC entry 266 (class 1255 OID 20295)
-- Name: sp_insert_penelitian(character varying, integer, text, character varying, character varying, text, integer[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_insert_penelitian(p_judul character varying, p_tahun integer, p_deskripsi text, p_link character varying, p_file character varying, p_anggota_luar text, p_peneliti integer[]) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_id INTEGER;
    peneliti_id INTEGER;
BEGIN
    -- Insert data utama
    INSERT INTO tbl_penelitian (
        judul_penelitian, 
        tahun_penelitian, 
        deskripsi_singkat, 
        link_publikasi, 
        file_dokumen_pdf, 
        anggota_luar,
        created_at
    ) VALUES (
        p_judul,
        p_tahun,
        p_deskripsi,
        p_link,
        p_file,
        p_anggota_luar,
        NOW()
    ) RETURNING id_penelitian INTO new_id;
    
    -- Insert anggota penelitian
    IF p_peneliti IS NOT NULL THEN
        FOREACH peneliti_id IN ARRAY p_peneliti
        LOOP
            INSERT INTO tbl_penelitian_anggota (id_penelitian, id_pengelola)
            VALUES (new_id, peneliti_id);
        END LOOP;
    END IF;
    
    RETURN new_id;
END;
$$;


ALTER FUNCTION public.sp_insert_penelitian(p_judul character varying, p_tahun integer, p_deskripsi text, p_link character varying, p_file character varying, p_anggota_luar text, p_peneliti integer[]) OWNER TO postgres;

--
-- TOC entry 267 (class 1255 OID 20296)
-- Name: sp_insert_pengabdian(json); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_insert_pengabdian(p_data json) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_id INTEGER;
    anggota_id INTEGER;
BEGIN
    -- Insert data utama
    INSERT INTO tbl_pengabdian (
        judul_kegiatan, 
        tahun_kegiatan, 
        deskripsi_kegiatan, 
        file_dokumen_pdf, 
        id_admin_pencatat,
        anggota_luar
    ) VALUES (
        p_data->>'judul_kegiatan',
        (p_data->>'tahun_kegiatan')::INTEGER,
        p_data->>'deskripsi_kegiatan',
        p_data->>'file_dokumen_pdf',
        (p_data->>'id_admin_pencatat')::INTEGER,
        p_data->>'anggota_luar'
    ) RETURNING id_pengabdian INTO new_id;
    
    -- Insert anggota pengabdian
    FOR anggota_id IN SELECT json_array_elements_text(p_data->'anggota_ids')::INTEGER
    LOOP
        INSERT INTO tbl_pengabdian_anggota (id_pengabdian, id_pengelola)
        VALUES (new_id, anggota_id);
    END LOOP;
    
    RETURN new_id;
END;
$$;


ALTER FUNCTION public.sp_insert_pengabdian(p_data json) OWNER TO postgres;

--
-- TOC entry 268 (class 1255 OID 20297)
-- Name: sp_insert_pengabdian(character varying, integer, text, character varying, integer, text, integer[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_insert_pengabdian(p_judul character varying, p_tahun integer, p_deskripsi text, p_file character varying, p_admin integer, p_anggota_luar text, p_anggota integer[]) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_id INTEGER;
    anggota_id INTEGER;
BEGIN
    -- Insert data utama
    INSERT INTO tbl_pengabdian (
        judul_kegiatan, 
        tahun_kegiatan, 
        deskripsi_kegiatan, 
        file_dokumen_pdf, 
        id_admin_pencatat,
        anggota_luar
    ) VALUES (
        p_judul,
        p_tahun,
        p_deskripsi,
        p_file,
        p_admin,
        p_anggota_luar
    ) RETURNING id_pengabdian INTO new_id;
    
    -- Insert anggota pengabdian
    IF p_anggota IS NOT NULL THEN
        FOREACH anggota_id IN ARRAY p_anggota
        LOOP
            INSERT INTO tbl_pengabdian_anggota (id_pengabdian, id_pengelola)
            VALUES (new_id, anggota_id);
        END LOOP;
    END IF;
    
    RETURN new_id;
END;
$$;


ALTER FUNCTION public.sp_insert_pengabdian(p_judul character varying, p_tahun integer, p_deskripsi text, p_file character varying, p_admin integer, p_anggota_luar text, p_anggota integer[]) OWNER TO postgres;

--
-- TOC entry 269 (class 1255 OID 20298)
-- Name: sp_insert_pengelola_with_keminatan(json); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_insert_pengelola_with_keminatan(p_data json) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_id INTEGER;
    keminatan_id INTEGER;
BEGIN
    -- Insert data pengelola
    INSERT INTO tbl_pengelola (
        nama_pengelola, 
        nid_nip, 
        id_jabatan, 
        foto_pengelola, 
        id_admin_pencatat
    ) VALUES (
        p_data->>'nama_pengelola',
        p_data->>'nid_nip',
        NULLIF(p_data->>'id_jabatan', '')::INTEGER,
        p_data->>'foto_pengelola',
        (p_data->>'id_admin_pencatat')::INTEGER
    ) RETURNING id_pengelola INTO new_id;
    
    -- Insert relasi keminatan
    IF p_data->'keminatan_ids' IS NOT NULL THEN
        FOR keminatan_id IN SELECT json_array_elements_text(p_data->'keminatan_ids')::INTEGER
        LOOP
            INSERT INTO tbl_pengelola_keminatan (id_pengelola, id_keminatan)
            VALUES (new_id, keminatan_id);
        END LOOP;
    END IF;
    
    RETURN new_id;
END;
$$;


ALTER FUNCTION public.sp_insert_pengelola_with_keminatan(p_data json) OWNER TO postgres;

--
-- TOC entry 270 (class 1255 OID 20299)
-- Name: sp_insert_pengelola_with_keminatan(character varying, character varying, integer, character varying, integer, integer[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_insert_pengelola_with_keminatan(p_nama character varying, p_nid_nip character varying, p_id_jabatan integer, p_foto character varying, p_admin integer, p_keminatan integer[]) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_id INTEGER;
    keminatan_id INTEGER;
BEGIN
    -- Insert data pengelola
    INSERT INTO tbl_pengelola (
        nama_pengelola, 
        nid_nip, 
        id_jabatan, 
        foto_pengelola, 
        id_admin_pencatat
    ) VALUES (
        p_nama,
        p_nid_nip,
        p_id_jabatan,
        p_foto,
        p_admin
    ) RETURNING id_pengelola INTO new_id;
    
    -- Insert relasi keminatan
    IF p_keminatan IS NOT NULL THEN
        FOREACH keminatan_id IN ARRAY p_keminatan
        LOOP
            INSERT INTO tbl_pengelola_keminatan (id_pengelola, id_keminatan)
            VALUES (new_id, keminatan_id);
        END LOOP;
    END IF;
    
    RETURN new_id;
END;
$$;


ALTER FUNCTION public.sp_insert_pengelola_with_keminatan(p_nama character varying, p_nid_nip character varying, p_id_jabatan integer, p_foto character varying, p_admin integer, p_keminatan integer[]) OWNER TO postgres;

--
-- TOC entry 271 (class 1255 OID 20300)
-- Name: sp_reset_admin_password(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_reset_admin_password(p_email character varying, p_token character varying, p_new_password character varying) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
DECLARE
    admin_record RECORD;
BEGIN
    -- Cari admin dengan email dan token yang valid
    SELECT * INTO admin_record
    FROM tbl_admin
    WHERE email = p_email
    AND reset_token = p_token
    AND reset_expires > NOW();
    
    -- Jika tidak ditemukan, return false
    IF NOT FOUND THEN
        RETURN FALSE;
    END IF;
    
    -- Update password dan hapus token
    UPDATE tbl_admin SET
        password = p_new_password,
        reset_token = NULL,
        reset_expires = NULL
    WHERE id_admin = admin_record.id_admin;
    
    RETURN TRUE;
END;
$$;


ALTER FUNCTION public.sp_reset_admin_password(p_email character varying, p_token character varying, p_new_password character varying) OWNER TO postgres;

--
-- TOC entry 272 (class 1255 OID 20301)
-- Name: sp_update_penelitian(integer, json); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_update_penelitian(p_id integer, p_data json) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
DECLARE
    peneliti_id INTEGER;
BEGIN
    -- Update data utama
    UPDATE tbl_penelitian SET
        judul_penelitian = p_data->>'judul_penelitian',
        tahun_penelitian = (p_data->>'tahun_penelitian')::INTEGER,
        deskripsi_singkat = p_data->>'deskripsi_singkat',
        link_publikasi = p_data->>'link_publikasi',
        file_dokumen_pdf = p_data->>'file_dokumen_pdf',
        anggota_luar = p_data->>'anggota_luar',
        updated_at = NOW()
    WHERE id_penelitian = p_id;
    
    -- Hapus anggota lama
    DELETE FROM tbl_penelitian_anggota WHERE id_penelitian = p_id;
    
    -- Insert anggota baru
    FOR peneliti_id IN SELECT json_array_elements_text(p_data->'peneliti')::INTEGER
    LOOP
        INSERT INTO tbl_penelitian_anggota (id_penelitian, id_pengelola)
        VALUES (p_id, peneliti_id);
    END LOOP;
    
    RETURN TRUE;
END;
$$;


ALTER FUNCTION public.sp_update_penelitian(p_id integer, p_data json) OWNER TO postgres;

--
-- TOC entry 273 (class 1255 OID 20302)
-- Name: sp_update_penelitian(integer, character varying, integer, text, character varying, character varying, text, integer[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_update_penelitian(p_id integer, p_judul character varying, p_tahun integer, p_deskripsi text, p_link character varying, p_file character varying, p_anggota_luar text, p_peneliti integer[]) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
DECLARE
    peneliti_id INTEGER;
BEGIN
    -- Update data utama
    UPDATE tbl_penelitian SET
        judul_penelitian = p_judul,
        tahun_penelitian = p_tahun,
        deskripsi_singkat = p_deskripsi,
        link_publikasi = p_link,
        file_dokumen_pdf = p_file,
        anggota_luar = p_anggota_luar,
        updated_at = NOW()
    WHERE id_penelitian = p_id;
    
    -- Hapus anggota lama
    DELETE FROM tbl_penelitian_anggota WHERE id_penelitian = p_id;
    
    -- Insert anggota baru
    IF p_peneliti IS NOT NULL THEN
        FOREACH peneliti_id IN ARRAY p_peneliti
        LOOP
            INSERT INTO tbl_penelitian_anggota (id_penelitian, id_pengelola)
            VALUES (p_id, peneliti_id);
        END LOOP;
    END IF;
    
    RETURN TRUE;
END;
$$;


ALTER FUNCTION public.sp_update_penelitian(p_id integer, p_judul character varying, p_tahun integer, p_deskripsi text, p_link character varying, p_file character varying, p_anggota_luar text, p_peneliti integer[]) OWNER TO postgres;

--
-- TOC entry 274 (class 1255 OID 20303)
-- Name: sp_update_pengabdian(integer, json); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_update_pengabdian(p_id integer, p_data json) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
DECLARE
    anggota_id INTEGER;
BEGIN
    -- Update data utama
    UPDATE tbl_pengabdian SET
        judul_kegiatan = p_data->>'judul_kegiatan',
        tahun_kegiatan = (p_data->>'tahun_kegiatan')::INTEGER,
        deskripsi_kegiatan = p_data->>'deskripsi_kegiatan',
        file_dokumen_pdf = p_data->>'file_dokumen_pdf',
        anggota_luar = p_data->>'anggota_luar'
    WHERE id_pengabdian = p_id;
    
    -- Hapus anggota lama
    DELETE FROM tbl_pengabdian_anggota WHERE id_pengabdian = p_id;
    
    -- Insert anggota baru
    FOR anggota_id IN SELECT json_array_elements_text(p_data->'anggota_ids')::INTEGER
    LOOP
        INSERT INTO tbl_pengabdian_anggota (id_pengabdian, id_pengelola)
        VALUES (p_id, anggota_id);
    END LOOP;
    
    RETURN TRUE;
END;
$$;


ALTER FUNCTION public.sp_update_pengabdian(p_id integer, p_data json) OWNER TO postgres;

--
-- TOC entry 275 (class 1255 OID 20304)
-- Name: sp_update_pengabdian(integer, character varying, integer, text, character varying, text, integer[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_update_pengabdian(p_id integer, p_judul character varying, p_tahun integer, p_deskripsi text, p_file character varying, p_anggota_luar text, p_anggota integer[]) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
DECLARE
    anggota_id INTEGER;
BEGIN
    -- Update data utama
    UPDATE tbl_pengabdian SET
        judul_kegiatan = p_judul,
        tahun_kegiatan = p_tahun,
        deskripsi_kegiatan = p_deskripsi,
        file_dokumen_pdf = p_file,
        anggota_luar = p_anggota_luar
    WHERE id_pengabdian = p_id;
    
    -- Hapus anggota lama
    DELETE FROM tbl_pengabdian_anggota WHERE id_pengabdian = p_id;
    
    -- Insert anggota baru
    IF p_anggota IS NOT NULL THEN
        FOREACH anggota_id IN ARRAY p_anggota
        LOOP
            INSERT INTO tbl_pengabdian_anggota (id_pengabdian, id_pengelola)
            VALUES (p_id, anggota_id);
        END LOOP;
    END IF;
    
    RETURN TRUE;
END;
$$;


ALTER FUNCTION public.sp_update_pengabdian(p_id integer, p_judul character varying, p_tahun integer, p_deskripsi text, p_file character varying, p_anggota_luar text, p_anggota integer[]) OWNER TO postgres;

--
-- TOC entry 252 (class 1255 OID 20305)
-- Name: sp_update_pengelola_with_keminatan(integer, json); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_update_pengelola_with_keminatan(p_id integer, p_data json) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
DECLARE
    keminatan_id INTEGER;
BEGIN
    -- Update data pengelola
    UPDATE tbl_pengelola SET
        nama_pengelola = p_data->>'nama_pengelola',
        nid_nip = p_data->>'nid_nip',
        id_jabatan = NULLIF(p_data->>'id_jabatan', '')::INTEGER,
        foto_pengelola = p_data->>'foto_pengelola'
    WHERE id_pengelola = p_id;
    
    -- Hapus relasi keminatan lama
    DELETE FROM tbl_pengelola_keminatan WHERE id_pengelola = p_id;
    
    -- Insert relasi keminatan baru
    IF p_data->'keminatan_ids' IS NOT NULL THEN
        FOR keminatan_id IN SELECT json_array_elements_text(p_data->'keminatan_ids')::INTEGER
        LOOP
            INSERT INTO tbl_pengelola_keminatan (id_pengelola, id_keminatan)
            VALUES (p_id, keminatan_id);
        END LOOP;
    END IF;
    
    RETURN TRUE;
END;
$$;


ALTER FUNCTION public.sp_update_pengelola_with_keminatan(p_id integer, p_data json) OWNER TO postgres;

--
-- TOC entry 276 (class 1255 OID 20306)
-- Name: sp_update_pengelola_with_keminatan(integer, character varying, character varying, integer, character varying, integer[]); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.sp_update_pengelola_with_keminatan(p_id integer, p_nama character varying, p_nid_nip character varying, p_id_jabatan integer, p_foto character varying, p_keminatan integer[]) RETURNS boolean
    LANGUAGE plpgsql
    AS $$
DECLARE
    keminatan_id INTEGER;
BEGIN
    -- Update data pengelola
    UPDATE tbl_pengelola SET
        nama_pengelola = p_nama,
        nid_nip = p_nid_nip,
        id_jabatan = p_id_jabatan,
        foto_pengelola = p_foto
    WHERE id_pengelola = p_id;
    
    -- Hapus relasi keminatan lama
    DELETE FROM tbl_pengelola_keminatan WHERE id_pengelola = p_id;
    
    -- Insert relasi keminatan baru
    IF p_keminatan IS NOT NULL THEN
        FOREACH keminatan_id IN ARRAY p_keminatan
        LOOP
            INSERT INTO tbl_pengelola_keminatan (id_pengelola, id_keminatan)
            VALUES (p_id, keminatan_id);
        END LOOP;
    END IF;
    
    RETURN TRUE;
END;
$$;


ALTER FUNCTION public.sp_update_pengelola_with_keminatan(p_id integer, p_nama character varying, p_nid_nip character varying, p_id_jabatan integer, p_foto character varying, p_keminatan integer[]) OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 214 (class 1259 OID 20307)
-- Name: tbl_admin; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_admin (
    id_admin integer NOT NULL,
    email character varying(100) NOT NULL,
    password character varying(255) NOT NULL,
    nama_lengkap character varying(150) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    reset_token character varying(64) DEFAULT NULL::character varying,
    reset_expires timestamp without time zone
);


ALTER TABLE public.tbl_admin OWNER TO postgres;

--
-- TOC entry 215 (class 1259 OID 20315)
-- Name: tbl_admin_id_admin_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_admin_id_admin_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_admin_id_admin_seq OWNER TO postgres;

--
-- TOC entry 3580 (class 0 OID 0)
-- Dependencies: 215
-- Name: tbl_admin_id_admin_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_admin_id_admin_seq OWNED BY public.tbl_admin.id_admin;


--
-- TOC entry 216 (class 1259 OID 20316)
-- Name: tbl_agenda; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_agenda (
    id_agenda integer NOT NULL,
    nama_agenda character varying(255) NOT NULL,
    deskripsi_agenda text,
    tanggal_mulai timestamp without time zone NOT NULL,
    tanggal_selesai timestamp without time zone,
    lokasi character varying(255),
    gambar_agenda character varying(255),
    id_admin_penulis integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.tbl_agenda OWNER TO postgres;

--
-- TOC entry 217 (class 1259 OID 20323)
-- Name: tbl_agenda_id_agenda_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_agenda_id_agenda_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_agenda_id_agenda_seq OWNER TO postgres;

--
-- TOC entry 3581 (class 0 OID 0)
-- Dependencies: 217
-- Name: tbl_agenda_id_agenda_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_agenda_id_agenda_seq OWNED BY public.tbl_agenda.id_agenda;


--
-- TOC entry 218 (class 1259 OID 20324)
-- Name: tbl_arsip; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_arsip (
    id_dokumen integer NOT NULL,
    nama_dokumen character varying(255) NOT NULL,
    nama_file_dokumen character varying(255) NOT NULL,
    deskripsi_dokumen text,
    id_admin_uploader integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    id_kategori_arsip integer
);


ALTER TABLE public.tbl_arsip OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 20331)
-- Name: tbl_arsip_id_dokumen_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_arsip_id_dokumen_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_arsip_id_dokumen_seq OWNER TO postgres;

--
-- TOC entry 3582 (class 0 OID 0)
-- Dependencies: 219
-- Name: tbl_arsip_id_dokumen_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_arsip_id_dokumen_seq OWNED BY public.tbl_arsip.id_dokumen;


--
-- TOC entry 220 (class 1259 OID 20332)
-- Name: tbl_berita; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_berita (
    id_berita integer NOT NULL,
    judul_berita character varying(255) NOT NULL,
    slug_berita character varying(255) NOT NULL,
    isi_berita text NOT NULL,
    gambar_berita character varying(255) DEFAULT 'default.jpg'::character varying NOT NULL,
    id_admin_penulis integer,
    tanggal_publish timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.tbl_berita OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 20341)
-- Name: tbl_berita_id_berita_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_berita_id_berita_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_berita_id_berita_seq OWNER TO postgres;

--
-- TOC entry 3583 (class 0 OID 0)
-- Dependencies: 221
-- Name: tbl_berita_id_berita_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_berita_id_berita_seq OWNED BY public.tbl_berita.id_berita;


--
-- TOC entry 222 (class 1259 OID 20342)
-- Name: tbl_galeri; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_galeri (
    id_foto integer NOT NULL,
    nama_file_foto character varying(255) NOT NULL,
    judul_foto character varying(255),
    deskripsi_foto text,
    id_admin_uploader integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.tbl_galeri OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 20349)
-- Name: tbl_galeri_id_foto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_galeri_id_foto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_galeri_id_foto_seq OWNER TO postgres;

--
-- TOC entry 3584 (class 0 OID 0)
-- Dependencies: 223
-- Name: tbl_galeri_id_foto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_galeri_id_foto_seq OWNED BY public.tbl_galeri.id_foto;


--
-- TOC entry 224 (class 1259 OID 20350)
-- Name: tbl_halaman_statis; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_halaman_statis (
    id_halaman integer NOT NULL,
    key_halaman character varying(50) NOT NULL,
    judul_halaman character varying(255) NOT NULL,
    isi_halaman text,
    id_admin_terakhir_edit integer,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.tbl_halaman_statis OWNER TO postgres;

--
-- TOC entry 225 (class 1259 OID 20356)
-- Name: tbl_halaman_statis_id_halaman_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_halaman_statis_id_halaman_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_halaman_statis_id_halaman_seq OWNER TO postgres;

--
-- TOC entry 3585 (class 0 OID 0)
-- Dependencies: 225
-- Name: tbl_halaman_statis_id_halaman_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_halaman_statis_id_halaman_seq OWNED BY public.tbl_halaman_statis.id_halaman;


--
-- TOC entry 226 (class 1259 OID 20357)
-- Name: tbl_jabatan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_jabatan (
    id_jabatan integer NOT NULL,
    nama_jabatan character varying(100) NOT NULL,
    deskripsi text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    kategori_jabatan character varying(50) DEFAULT 'Peneliti'::character varying
);


ALTER TABLE public.tbl_jabatan OWNER TO postgres;

--
-- TOC entry 227 (class 1259 OID 20364)
-- Name: tbl_jabatan_id_jabatan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_jabatan_id_jabatan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_jabatan_id_jabatan_seq OWNER TO postgres;

--
-- TOC entry 3586 (class 0 OID 0)
-- Dependencies: 227
-- Name: tbl_jabatan_id_jabatan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_jabatan_id_jabatan_seq OWNED BY public.tbl_jabatan.id_jabatan;


--
-- TOC entry 228 (class 1259 OID 20365)
-- Name: tbl_kategori_arsip; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_kategori_arsip (
    id_kategori_arsip integer NOT NULL,
    nama_kategori character varying(100) NOT NULL
);


ALTER TABLE public.tbl_kategori_arsip OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 20368)
-- Name: tbl_kategori_arsip_id_kategori_arsip_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_kategori_arsip_id_kategori_arsip_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_kategori_arsip_id_kategori_arsip_seq OWNER TO postgres;

--
-- TOC entry 3587 (class 0 OID 0)
-- Dependencies: 229
-- Name: tbl_kategori_arsip_id_kategori_arsip_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_kategori_arsip_id_kategori_arsip_seq OWNED BY public.tbl_kategori_arsip.id_kategori_arsip;


--
-- TOC entry 230 (class 1259 OID 20369)
-- Name: tbl_keminatan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_keminatan (
    id_keminatan integer NOT NULL,
    nama_keminatan character varying(100) NOT NULL,
    deskripsi text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.tbl_keminatan OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 20376)
-- Name: tbl_keminatan_id_keminatan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_keminatan_id_keminatan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_keminatan_id_keminatan_seq OWNER TO postgres;

--
-- TOC entry 3588 (class 0 OID 0)
-- Dependencies: 231
-- Name: tbl_keminatan_id_keminatan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_keminatan_id_keminatan_seq OWNED BY public.tbl_keminatan.id_keminatan;


--
-- TOC entry 232 (class 1259 OID 20377)
-- Name: tbl_konsultasi; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_konsultasi (
    id_konsultasi integer NOT NULL,
    nama_penanya character varying(100) NOT NULL,
    email_penanya character varying(100) NOT NULL,
    pertanyaan text NOT NULL,
    jawaban text,
    id_admin_penjawab integer,
    status_jawaban character varying(20) DEFAULT 'pending'::character varying,
    tanggal_tanya timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    tanggal_jawab timestamp without time zone,
    alasan_tolak text
);


ALTER TABLE public.tbl_konsultasi OWNER TO postgres;

--
-- TOC entry 233 (class 1259 OID 20384)
-- Name: tbl_konsultasi_id_konsultasi_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_konsultasi_id_konsultasi_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_konsultasi_id_konsultasi_seq OWNER TO postgres;

--
-- TOC entry 3589 (class 0 OID 0)
-- Dependencies: 233
-- Name: tbl_konsultasi_id_konsultasi_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_konsultasi_id_konsultasi_seq OWNED BY public.tbl_konsultasi.id_konsultasi;


--
-- TOC entry 234 (class 1259 OID 20385)
-- Name: tbl_penelitian; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_penelitian (
    id_penelitian integer NOT NULL,
    judul_penelitian character varying(255) NOT NULL,
    tahun_penelitian character varying(4) NOT NULL,
    deskripsi_singkat text,
    link_publikasi character varying(255),
    file_dokumen_pdf character varying(255),
    id_admin_pencatat integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    anggota_luar text
);


ALTER TABLE public.tbl_penelitian OWNER TO postgres;

--
-- TOC entry 3590 (class 0 OID 0)
-- Dependencies: 234
-- Name: COLUMN tbl_penelitian.anggota_luar; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.tbl_penelitian.anggota_luar IS 'Nama-nama anggota peneliti dari luar organisasi (non-pengelola). Format: teks bebas atau JSON array string';


--
-- TOC entry 235 (class 1259 OID 20392)
-- Name: tbl_penelitian_anggota; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_penelitian_anggota (
    id_penelitian integer NOT NULL,
    id_pengelola integer NOT NULL
);


ALTER TABLE public.tbl_penelitian_anggota OWNER TO postgres;

--
-- TOC entry 236 (class 1259 OID 20395)
-- Name: tbl_penelitian_id_penelitian_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_penelitian_id_penelitian_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_penelitian_id_penelitian_seq OWNER TO postgres;

--
-- TOC entry 3591 (class 0 OID 0)
-- Dependencies: 236
-- Name: tbl_penelitian_id_penelitian_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_penelitian_id_penelitian_seq OWNED BY public.tbl_penelitian.id_penelitian;


--
-- TOC entry 237 (class 1259 OID 20396)
-- Name: tbl_pengabdian; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_pengabdian (
    id_pengabdian integer NOT NULL,
    judul_kegiatan character varying(255) NOT NULL,
    tahun_kegiatan character varying(4) NOT NULL,
    deskripsi_kegiatan text,
    file_dokumen_pdf character varying(255),
    id_admin_pencatat integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    anggota_luar text
);


ALTER TABLE public.tbl_pengabdian OWNER TO postgres;

--
-- TOC entry 3592 (class 0 OID 0)
-- Dependencies: 237
-- Name: COLUMN tbl_pengabdian.anggota_luar; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.tbl_pengabdian.anggota_luar IS 'Nama-nama anggota pengabdi dari luar organisasi (non-pengelola). Format: teks bebas atau JSON array string';


--
-- TOC entry 238 (class 1259 OID 20403)
-- Name: tbl_pengabdian_anggota; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_pengabdian_anggota (
    id_pengabdian integer NOT NULL,
    id_pengelola integer NOT NULL
);


ALTER TABLE public.tbl_pengabdian_anggota OWNER TO postgres;

--
-- TOC entry 239 (class 1259 OID 20406)
-- Name: tbl_pengabdian_id_pengabdian_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_pengabdian_id_pengabdian_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_pengabdian_id_pengabdian_seq OWNER TO postgres;

--
-- TOC entry 3593 (class 0 OID 0)
-- Dependencies: 239
-- Name: tbl_pengabdian_id_pengabdian_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_pengabdian_id_pengabdian_seq OWNED BY public.tbl_pengabdian.id_pengabdian;


--
-- TOC entry 240 (class 1259 OID 20407)
-- Name: tbl_pengelola; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_pengelola (
    id_pengelola integer NOT NULL,
    nama_pengelola character varying(150) NOT NULL,
    foto_pengelola character varying(255) DEFAULT 'default-avatar.png'::character varying,
    id_admin_pencatat integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    nid_nip character varying(50),
    id_jabatan integer,
    linkedin_url character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.tbl_pengelola OWNER TO postgres;

--
-- TOC entry 3594 (class 0 OID 0)
-- Dependencies: 240
-- Name: COLUMN tbl_pengelola.linkedin_url; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.tbl_pengelola.linkedin_url IS 'URL LinkedIn profile untuk pengelola';


--
-- TOC entry 241 (class 1259 OID 20416)
-- Name: tbl_pengelola_id_pengelola_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_pengelola_id_pengelola_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_pengelola_id_pengelola_seq OWNER TO postgres;

--
-- TOC entry 3595 (class 0 OID 0)
-- Dependencies: 241
-- Name: tbl_pengelola_id_pengelola_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_pengelola_id_pengelola_seq OWNED BY public.tbl_pengelola.id_pengelola;


--
-- TOC entry 242 (class 1259 OID 20417)
-- Name: tbl_pengelola_keminatan; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_pengelola_keminatan (
    id_pengelola_keminatan integer NOT NULL,
    id_pengelola integer NOT NULL,
    id_keminatan integer NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.tbl_pengelola_keminatan OWNER TO postgres;

--
-- TOC entry 243 (class 1259 OID 20421)
-- Name: tbl_pengelola_keminatan_id_pengelola_keminatan_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_pengelola_keminatan_id_pengelola_keminatan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_pengelola_keminatan_id_pengelola_keminatan_seq OWNER TO postgres;

--
-- TOC entry 3596 (class 0 OID 0)
-- Dependencies: 243
-- Name: tbl_pengelola_keminatan_id_pengelola_keminatan_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_pengelola_keminatan_id_pengelola_keminatan_seq OWNED BY public.tbl_pengelola_keminatan.id_pengelola_keminatan;


--
-- TOC entry 244 (class 1259 OID 20422)
-- Name: tbl_sarana_prasarana; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tbl_sarana_prasarana (
    id_sarana integer NOT NULL,
    nama_sarana character varying(255) NOT NULL,
    deskripsi_sarana text,
    foto_sarana character varying(255),
    jumlah integer DEFAULT 1,
    kondisi character varying(100),
    id_admin_pencatat integer,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.tbl_sarana_prasarana OWNER TO postgres;

--
-- TOC entry 245 (class 1259 OID 20430)
-- Name: tbl_sarana_prasarana_id_sarana_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tbl_sarana_prasarana_id_sarana_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tbl_sarana_prasarana_id_sarana_seq OWNER TO postgres;

--
-- TOC entry 3597 (class 0 OID 0)
-- Dependencies: 245
-- Name: tbl_sarana_prasarana_id_sarana_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tbl_sarana_prasarana_id_sarana_seq OWNED BY public.tbl_sarana_prasarana.id_sarana;


--
-- TOC entry 247 (class 1259 OID 20436)
-- Name: v_arsip_gabungan; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public.v_arsip_gabungan AS
 SELECT 'penelitian'::text AS sumber_tabel,
    tp.id_penelitian AS id_asli,
    tp.judul_penelitian AS judul,
    tp.deskripsi_singkat AS deskripsi,
    tp.file_dokumen_pdf AS nama_file,
    tp.created_at,
    'Penelitian'::text AS kategori,
    COALESCE(( SELECT string_agg((p.nama_pengelola)::text, ', '::text) AS string_agg
           FROM (public.tbl_penelitian_anggota tpa
             JOIN public.tbl_pengelola p ON ((tpa.id_pengelola = p.id_pengelola)))
          WHERE (tpa.id_penelitian = tp.id_penelitian)), 'Tim Peneliti'::text) AS penulis_atau_tim,
    (tp.tahun_penelitian)::text AS tahun,
    tp.link_publikasi AS link_eksternal
   FROM public.tbl_penelitian tp
UNION ALL
 SELECT 'pengabdian'::text AS sumber_tabel,
    tpb.id_pengabdian AS id_asli,
    tpb.judul_kegiatan AS judul,
    tpb.deskripsi_kegiatan AS deskripsi,
    tpb.file_dokumen_pdf AS nama_file,
    tpb.created_at,
    'Pengabdian'::text AS kategori,
    COALESCE(( SELECT string_agg((p.nama_pengelola)::text, ', '::text) AS string_agg
           FROM (public.tbl_pengabdian_anggota tpa2
             JOIN public.tbl_pengelola p ON ((tpa2.id_pengelola = p.id_pengelola)))
          WHERE (tpa2.id_pengabdian = tpb.id_pengabdian)), 'Tim Pengabdi'::text) AS penulis_atau_tim,
    (tpb.tahun_kegiatan)::text AS tahun,
    NULL::character varying AS link_eksternal
   FROM public.tbl_pengabdian tpb
UNION ALL
 SELECT 'arsip_umum'::text AS sumber_tabel,
    ar.id_dokumen AS id_asli,
    ar.nama_dokumen AS judul,
    ar.deskripsi_dokumen AS deskripsi,
    ar.nama_file_dokumen AS nama_file,
    ar.created_at,
    COALESCE(k.nama_kategori, 'Dokumen Umum'::character varying) AS kategori,
    a.nama_lengkap AS penulis_atau_tim,
    to_char(ar.created_at, 'YYYY'::text) AS tahun,
    NULL::character varying AS link_eksternal
   FROM ((public.tbl_arsip ar
     LEFT JOIN public.tbl_kategori_arsip k ON ((ar.id_kategori_arsip = k.id_kategori_arsip)))
     LEFT JOIN public.tbl_admin a ON ((ar.id_admin_uploader = a.id_admin)));


ALTER TABLE public.v_arsip_gabungan OWNER TO postgres;


--
-- TOC entry 3283 (class 2604 OID 20451)
-- Name: tbl_admin id_admin; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_admin ALTER COLUMN id_admin SET DEFAULT nextval('public.tbl_admin_id_admin_seq'::regclass);


--
-- TOC entry 3287 (class 2604 OID 20452)
-- Name: tbl_agenda id_agenda; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_agenda ALTER COLUMN id_agenda SET DEFAULT nextval('public.tbl_agenda_id_agenda_seq'::regclass);


--
-- TOC entry 3290 (class 2604 OID 20453)
-- Name: tbl_arsip id_dokumen; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_arsip ALTER COLUMN id_dokumen SET DEFAULT nextval('public.tbl_arsip_id_dokumen_seq'::regclass);


--
-- TOC entry 3293 (class 2604 OID 20454)
-- Name: tbl_berita id_berita; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_berita ALTER COLUMN id_berita SET DEFAULT nextval('public.tbl_berita_id_berita_seq'::regclass);


--
-- TOC entry 3298 (class 2604 OID 20455)
-- Name: tbl_galeri id_foto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_galeri ALTER COLUMN id_foto SET DEFAULT nextval('public.tbl_galeri_id_foto_seq'::regclass);


--
-- TOC entry 3301 (class 2604 OID 20456)
-- Name: tbl_halaman_statis id_halaman; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_halaman_statis ALTER COLUMN id_halaman SET DEFAULT nextval('public.tbl_halaman_statis_id_halaman_seq'::regclass);


--
-- TOC entry 3303 (class 2604 OID 20457)
-- Name: tbl_jabatan id_jabatan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_jabatan ALTER COLUMN id_jabatan SET DEFAULT nextval('public.tbl_jabatan_id_jabatan_seq'::regclass);


--
-- TOC entry 3307 (class 2604 OID 20458)
-- Name: tbl_kategori_arsip id_kategori_arsip; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_kategori_arsip ALTER COLUMN id_kategori_arsip SET DEFAULT nextval('public.tbl_kategori_arsip_id_kategori_arsip_seq'::regclass);


--
-- TOC entry 3308 (class 2604 OID 20459)
-- Name: tbl_keminatan id_keminatan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_keminatan ALTER COLUMN id_keminatan SET DEFAULT nextval('public.tbl_keminatan_id_keminatan_seq'::regclass);


--
-- TOC entry 3311 (class 2604 OID 20460)
-- Name: tbl_konsultasi id_konsultasi; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_konsultasi ALTER COLUMN id_konsultasi SET DEFAULT nextval('public.tbl_konsultasi_id_konsultasi_seq'::regclass);


--
-- TOC entry 3314 (class 2604 OID 20461)
-- Name: tbl_penelitian id_penelitian; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_penelitian ALTER COLUMN id_penelitian SET DEFAULT nextval('public.tbl_penelitian_id_penelitian_seq'::regclass);


--
-- TOC entry 3317 (class 2604 OID 20462)
-- Name: tbl_pengabdian id_pengabdian; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengabdian ALTER COLUMN id_pengabdian SET DEFAULT nextval('public.tbl_pengabdian_id_pengabdian_seq'::regclass);


--
-- TOC entry 3320 (class 2604 OID 20463)
-- Name: tbl_pengelola id_pengelola; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengelola ALTER COLUMN id_pengelola SET DEFAULT nextval('public.tbl_pengelola_id_pengelola_seq'::regclass);


--
-- TOC entry 3325 (class 2604 OID 20464)
-- Name: tbl_pengelola_keminatan id_pengelola_keminatan; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengelola_keminatan ALTER COLUMN id_pengelola_keminatan SET DEFAULT nextval('public.tbl_pengelola_keminatan_id_pengelola_keminatan_seq'::regclass);


--
-- TOC entry 3327 (class 2604 OID 20465)
-- Name: tbl_sarana_prasarana id_sarana; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_sarana_prasarana ALTER COLUMN id_sarana SET DEFAULT nextval('public.tbl_sarana_prasarana_id_sarana_seq'::regclass);


--
-- TOC entry 3543 (class 0 OID 20307)
-- Dependencies: 214
-- Data for Name: tbl_admin; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_admin (id_admin, email, password, nama_lengkap, created_at, updated_at, reset_token, reset_expires) FROM stdin;
1	muhammadibnzzi@gmail.com	$2y$10$tvzGCmrVVHFZyAoRVQeNcu0/CYwryCAMxZqiH7f36IaCCvAKV9HIS	Admin Pertama Horex	2025-11-11 15:11:03.419912	2025-11-11 15:11:03.419912	\N	\N
\.


--
-- TOC entry 3545 (class 0 OID 20316)
-- Dependencies: 216
-- Data for Name: tbl_agenda; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_agenda (id_agenda, nama_agenda, deskripsi_agenda, tanggal_mulai, tanggal_selesai, lokasi, gambar_agenda, id_admin_penulis, created_at, updated_at) FROM stdin;
22	Kunjungan Industri ke NOC Telkom	Kunjungan mahasiswa ke Network Operation Center Telkom untuk melihat infrastruktur jaringan skala nasional.	2025-05-28 08:00:00	2025-05-28 16:00:00	Telkom Regional VII Makassar	agenda_1765733320_4399.jpg	1	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
20	Open Lab - Konsultasi Tugas Akhir	Sesi konsultasi gratis untuk mahasiswa yang sedang mengerjakan TA/skripsi terkait jaringan dan keamanan siber.	2025-04-25 13:00:00	2025-04-25 17:00:00	Lab NCS LT 8	agenda_1765733336_1418.jpg	1	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
19	Training Internet of Things (IoT)	Pelatihan IoT menggunakan ESP32, sensor, dan protokol MQTT. Proyek akhir: smart home automation system.	2025-04-08 09:00:00	2025-04-10 16:00:00	Lab NCS LT 8	agenda_1765733344_2781.jpg	1	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
21	Bootcamp Network Automation Python	Bootcamp 3 hari belajar automasi jaringan dengan Python, Netmiko, NAPALM, dan Ansible untuk multi-vendor devices.	2025-05-12 08:00:00	2025-05-14 17:00:00	Lab NCS LT 8	agenda_1765733327_6714.jpg	1	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
18	Rapat Koordinasi Penelitian	Koordinasi progress penelitian dosen dan mahasiswa, review publikasi, dan perencanaan hibah penelitian tahun 2025.	2025-03-18 10:00:00	2025-03-18 12:00:00	RT 4 LT 5	agenda_1765733353_5587.jpg	1	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
17	Webinar Cloud Security Best Practices	Webinar gratis membahas security pada AWS, Azure, dan GCP. Topik: IAM, encryption, compliance, dan incident response.	2025-03-10 14:00:00	2025-03-10 16:00:00	Online via Zoom	agenda_1765733361_1494.jpg	1	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
15	Pelatihan Mikrotik MTCNA	Pelatihan sertifikasi Mikrotik Certified Network Associate selama 3 hari, materi routing, firewall, QoS, dan wireless.	2025-02-05 08:00:00	2025-02-07 17:00:00	Auditorium LT 8	agenda_1765733377_2921.jpg	1	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
16	Kompetisi Capture The Flag (CTF)	Kompetisi CTF tingkat universitas dengan kategori web exploitation, cryptography, reverse engineering, dan forensics.	2025-02-20 08:00:00	2025-02-20 18:00:00	Auditorium LT 8	agenda_1765733370_1450.jpg	1	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
14	Seminar Cybersecurity Trends 2025	Seminar nasional menghadirkan praktisi industri membahas tren keamanan siber, AI in security, dan zero-trust architecture.	2025-01-22 13:00:00	2025-01-22 17:00:00	Auditorium LT 8	agenda_1765733393_4238.jpg	1	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
13	Workshop Ethical Hacking	Workshop intensif tentang teknik penetration testing menggunakan Kali Linux, Metasploit, dan Burp Suite. Materi mencakup reconnaissance, exploitation, dan post-exploitation.	2025-01-15 09:00:00	2025-01-15 16:00:00	Auditorium LT 6	agenda_1765733412_2512.jpg	1	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
\.


--
-- TOC entry 3547 (class 0 OID 20324)
-- Dependencies: 218
-- Data for Name: tbl_arsip; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_arsip (id_dokumen, nama_dokumen, nama_file_dokumen, deskripsi_dokumen, id_admin_uploader, created_at, updated_at, id_kategori_arsip) FROM stdin;
2	Form Permohonan Layanan Lab	dokumen_1765724100.pdf	Form Permohonan Layanan Lab NCS	1	2025-12-14 21:55:00.667232	2025-12-14 21:55:00.667232	1
3	SOP Praktikum Lab NCS	dokumen_1765724124.pdf	SOP Praktikum Lab NCS	1	2025-12-14 21:55:24.511674	2025-12-14 21:55:24.511674	2
\.


--
-- TOC entry 3549 (class 0 OID 20332)
-- Dependencies: 220
-- Data for Name: tbl_berita; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_berita (id_berita, judul_berita, slug_berita, isi_berita, gambar_berita, id_admin_penulis, tanggal_publish, created_at, updated_at) FROM stdin;
39	Webinar Cloud Native Security Diikuti 500+ Peserta	webinar-cloud-native-security-diikuti-500-peserta	<p>Webinar online Lab NCS bertajuk <strong>"Securing Cloud Native Applications"</strong> pada 10 Oktober 2024 diikuti lebih dari 500 peserta dari seluruh Indonesia.</p><p>Narasumber adalah Bapak Ahmad Zainuddin, Senior DevSecOps Engineer dari Gojek. Materi mencakup Kubernetes security, container scanning, service mesh, dan zero-trust architecture.</p><p>Webinar berlangsung 2 jam dengan sesi Q&A yang interaktif. "Materinya sangat applicable untuk proyek di tempat kerja," kata salah satu peserta dari Jakarta. Recording webinar tersedia di YouTube Lab NCS.</p>	berita_1765733234_7294.jpg	\N	2024-10-12 00:00:00	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
40	Lab NCS Jadi Host Regional CTF Championship	lab-ncs-jadi-host-regional-ctf-championship	<p>Lab NCS ditunjuk sebagai <strong>official host Regional CTF Championship Kawasan Timur Indonesia (KTI)</strong> yang akan diselenggarakan pada 20 Februari 2025.</p><p>Kompetisi ini diikuti peserta dari Sulawesi, Maluku, Papua, dan NTT dengan total hadiah 100 juta rupiah. Kategori: web, crypto, forensics, reverse engineering, dan pwn.</p><p>"Kami akan sediakan infrastruktur server kelas enterprise dan challenge berkualitas internasional," janjikan panitia. Registrasi dibuka 15 Januari 2025 di ctf.labncs.ac.id.</p>	berita_1765733267_3538.jpg	\N	2024-10-05 00:00:00	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
33	Kerja Sama Lab NCS dengan Cisco Networking Academy	kerja-sama-lab-ncs-dengan-cisco-networking-academy	<p>Lab NCS resmi menjadi <strong>Cisco Networking Academy</strong> dan dapat menyelenggarakan pelatihan sertifikasi CCNA, CCNP, dan CyberOps mulai Januari 2025.</p><p>Kerja sama ini memberikan akses mahasiswa dan dosen ke kurikulum Cisco terbaru, lab virtual Packet Tracer, dan voucher ujian sertifikasi dengan harga khusus pendidikan.</p><p>"Kami berkomitmen mencetak network engineer berkualitas global," kata Sofyan Noor, koordinator program sertifikasi. Pendaftaran batch pertama dibuka 10 Januari 2025 untuk 30 peserta.</p>	berita_1765733174_8392.jpg	\N	2024-11-25 00:00:00	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
31	Lab NCS Raih Akreditasi Internasional ABET	lab-ncs-raih-akreditasi-internasional-abet	<p>Laboratorium Network and Cyber Security (NCS) Politeknik Negeri Ujung Pandang berhasil meraih akreditasi internasional dari <strong>Accreditation Board for Engineering and Technology (ABET)</strong> pada Desember 2024.</p><p>Akreditasi ini membuktikan bahwa fasilitas, kurikulum, dan kompetensi Lab NCS telah memenuhi standar global dalam pendidikan teknik dan teknologi. "Ini adalah pencapaian luar biasa bagi kami," ujar Dr. Erfan Rohadi sebagai Kepala Lab.</p><p>Dengan akreditasi ABET, lulusan yang pernah praktikum di Lab NCS memiliki nilai tambah di pasar kerja internasional, terutama untuk posisi network engineer dan cybersecurity analyst.</p>	berita_1765733156_3409.jpg	\N	2024-12-10 00:00:00	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
32	Mahasiswa Lab NCS Juara 1 CTF Nasional	mahasiswa-lab-ncs-juara-1-ctf-nasional	<p>Tim mahasiswa Lab NCS yang terdiri dari Ade Ismail, Sofyan Noor, dan Meyti Eka berhasil meraih <strong>juara 1 kompetisi Capture The Flag (CTF)</strong> tingkat nasional yang diselenggarakan oleh BSSN pada 5-7 Desember 2024.</p><p>Tim "NCS Elite" mengalahkan 150+ tim dari seluruh Indonesia dalam kategori web exploitation, reverse engineering, dan forensics. Mereka berhasil mengumpulkan 8500 poin dalam waktu 48 jam non-stop.</p><p>"Pelatihan rutin di lab dan bimbingan dari dosen sangat membantu kami," ucap Ade Ismail sebagai ketua tim. Mereka membawa pulang hadiah 25 juta rupiah dan sertifikat.</p>	berita_1765733164_5714.jpg	\N	2024-12-08 00:00:00	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
34	Penelitian Lab NCS Terbit di IEEE Transaction	penelitian-lab-ncs-terbit-di-ieee-transaction	<p>Penelitian dosen Lab NCS tentang <em>"AI-based Intrusion Detection System for IoT Networks"</em> berhasil diterbitkan di jurnal internasional bereputasi <strong>IEEE Transactions on Network and Service Management</strong> (Q1, Impact Factor 4.7).</p><p>Penelitian ini dipimpin oleh Dr. Erfan Rohadi dengan anggota Vipkas Al Hadid dan Ade Ismail. Mereka mengembangkan algoritma machine learning yang mampu mendeteksi serangan DDoS pada jaringan IoT dengan akurasi 98.3%.</p><p>"Publikasi ini membuktikan riset Lab NCS setara dengan universitas top dunia," ujar Rektor PNUP saat memberikan apresiasi.</p>	berita_1765733183_6114.jpg	\N	2024-11-20 00:00:00	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
35	Workshop 5G Security Hadirkan Expert dari Huawei	workshop-5g-security-hadirkan-expert-dari-huawei	<p>Lab NCS mengadakan workshop <strong>"5G Network Security"</strong> yang menghadirkan Bapak Zhang Wei, Senior Security Engineer dari Huawei Technologies pada 18 November 2024.</p><p>Workshop diikuti 80+ peserta dari berbagai universitas se-Sulawesi. Materi mencakup arsitektur 5G, vulnerabilities, network slicing security, dan 5G encryption.</p><p>Selain teori, peserta juga praktik langsung menggunakan simulator 5G core network. "Ini pengalaman berharga memahami teknologi masa depan," kata salah satu peserta.</p>	berita_1765733191_9158.jpg	\N	2024-11-18 00:00:00	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
36	Lab NCS Tambah 20 Unit Laptop ROG untuk Mahasiswa	lab-ncs-tambah-20-unit-laptop-rog-untuk-mahasiswa	<p>Dalam rangka meningkatkan fasilitas praktikum, Lab NCS menambah <strong>20 unit laptop Asus ROG Strix G15</strong> senilai 400 juta rupiah dari anggaran hibah Kemendikbud.</p><p>Laptop gaming ini dikhususkan untuk praktikum penetration testing, malware analysis, dan network simulation yang membutuhkan spesifikasi tinggi.</p><p>"Mahasiswa tidak perlu repot bawa laptop pribadi lagi. Semua kebutuhan praktikum sudah kami sediakan," ujar Kepala Lab. Laptop sudah bisa digunakan mulai semester genap 2024/2025.</p>	berita_1765733201_7531.jpg	\N	2024-11-05 00:00:00	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
37	Lulusan Lab NCS Diterima di Google Cloud	lulusan-lab-ncs-diterima-di-google-cloud	<p><strong>Alumni Lab NCS angkatan 2022, Meyti Eka Apriyani</strong>, berhasil diterima sebagai Cloud Security Engineer di Google Cloud Singapura dengan gaji starting USD 120,000 per tahun.</p><p>"Pengalaman praktikum di Lab NCS dan sertifikasi CCNA sangat membantu saya saat interview," ungkap Meyti via video call. Dia adalah lulusan pertama Lab NCS yang bekerja di Google.</p><p>Meyti aktif di Lab sejak semester 3, pernah menjadi asisten praktikum, dan juga juara CTF tingkat nasional. "Ini motivasi untuk adik-adik tingkat," pesannya.</p>	berita_1765733216_3143.jpg	\N	2024-10-28 00:00:00	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
38	Lab NCS Luncurkan Program Mentoring Gratis	lab-ncs-luncurkan-program-mentoring-gratis	<p>Mulai November 2024, Lab NCS meluncurkan <strong>program mentoring gratis</strong> untuk mahasiswa yang ingin fokus di bidang networking dan cybersecurity.</p><p>Program ini membuka 50 slot per semester dengan pendampingan dari dosen dan praktisi industri. Peserta akan mendapat jalur pembelajaran terstruktur: sertifikasi → kompetisi → magang → pekerjaan.</p><p>"Kami ingin semua mahasiswa punya kesempatan yang sama untuk berkembang," kata Sofyan Noor, PIC program. Pendaftaran dibuka setiap awal semester via website Lab NCS.</p>	berita_1765733225_7992.jpg	\N	2024-10-15 00:00:00	2025-12-15 00:24:40.677808	2025-12-15 00:24:40.677808
\.


--
-- TOC entry 3551 (class 0 OID 20342)
-- Dependencies: 222
-- Data for Name: tbl_galeri; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_galeri (id_foto, nama_file_foto, judul_foto, deskripsi_foto, id_admin_uploader, created_at, updated_at) FROM stdin;
9	foto_1765118365_9400.jpg	gambar7	Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.	1	2025-12-07 20:27:34.290545	2025-12-07 21:39:25.101895
8	foto_1765118602_3851.jpg	gambar6	Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.	1	2025-12-07 20:27:18.761767	2025-12-07 21:43:22.868785
7	foto_1765118627_7990.jpg	gambar5	Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.	1	2025-12-07 20:27:00.730844	2025-12-07 21:43:47.031351
6	foto_1765118634_3117.jpg	gambar4	Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.	1	2025-12-07 20:26:49.262426	2025-12-07 21:43:54.72922
5	foto_1765118643_5542.jpg	gambar3	Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.	1	2025-12-07 20:26:31.638842	2025-12-07 21:44:03.306734
4	foto_1765118649_8976.jpg	gambar2	Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.	1	2025-12-07 20:26:16.709643	2025-12-07 21:44:09.509975
3	foto_1765118656_7250.jpg	gambar1	Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.	1	2025-12-07 20:26:00.591848	2025-12-07 21:44:16.682904
\.


--
-- TOC entry 3553 (class 0 OID 20350)
-- Dependencies: 224
-- Data for Name: tbl_halaman_statis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_halaman_statis (id_halaman, key_halaman, judul_halaman, isi_halaman, id_admin_terakhir_edit, updated_at) FROM stdin;
\.


--
-- TOC entry 3555 (class 0 OID 20357)
-- Dependencies: 226
-- Data for Name: tbl_jabatan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_jabatan (id_jabatan, nama_jabatan, deskripsi, created_at, updated_at, kategori_jabatan) FROM stdin;
6	Peneliti	Peneliti Laboratorium	2025-12-04 11:36:29.579834	2025-12-07 21:48:17.125739	Peneliti
1	Kepala Laboratorium	Kepala Laboratorium Network and Computer System	2025-12-04 11:36:29.579834	2025-12-07 21:48:22.14131	Kepala Laboratorium
\.


--
-- TOC entry 3557 (class 0 OID 20365)
-- Dependencies: 228
-- Data for Name: tbl_kategori_arsip; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_kategori_arsip (id_kategori_arsip, nama_kategori) FROM stdin;
4	Penelitian
5	Pengabdian
2	SOP Praktikum
1	Form Permohonan Layanan
\.


--
-- TOC entry 3559 (class 0 OID 20369)
-- Dependencies: 230
-- Data for Name: tbl_keminatan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_keminatan (id_keminatan, nama_keminatan, deskripsi, created_at, updated_at) FROM stdin;
3	Cloud Computing	Keilmuan bidang komputasi awan dan virtualisasi	2025-12-04 11:36:29.579834	2025-12-04 11:36:29.579834
4	Internet of Things	Keilmuan bidang IoT dan sistem embedded	2025-12-04 11:36:29.579834	2025-12-04 11:36:29.579834
5	Database	Keilmuan bidang database dan big data	2025-12-04 11:36:29.579834	2025-12-04 11:36:29.579834
9	Wireless Technology		2025-12-07 21:49:14.278058	2025-12-07 21:49:14.278058
10	Antenna		2025-12-07 21:49:23.543536	2025-12-07 21:49:23.543536
11	Information System		2025-12-07 21:49:34.99381	2025-12-07 21:49:34.99381
2	Cyber Security	Keilmuan bidang keamanan siber dan kriptografi	2025-12-04 11:36:29.579834	2025-12-07 21:49:54.304809
1	Computer Networking	Keilmuan bidang jaringan komputer dan infrastruktur	2025-12-04 11:36:29.579834	2025-12-07 21:50:08.39495
12	Information Security		2025-12-07 21:50:53.140452	2025-12-07 21:50:53.140452
13	Artificial Intelligence		2025-12-07 21:51:03.327514	2025-12-07 21:51:03.327514
14	Informatika		2025-12-07 21:51:27.360995	2025-12-07 21:51:27.360995
15	Multimedia		2025-12-07 21:51:39.765163	2025-12-07 21:51:39.765163
\.


--
-- TOC entry 3561 (class 0 OID 20377)
-- Dependencies: 232
-- Data for Name: tbl_konsultasi; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_konsultasi (id_konsultasi, nama_penanya, email_penanya, pertanyaan, jawaban, id_admin_penjawab, status_jawaban, tanggal_tanya, tanggal_jawab, alasan_tolak) FROM stdin;
24	Ahmad Fauzan	ahmad.fauzan@student.pnup.ac.id	Kapan jadwal pelatihan sertifikasi CCNA batch selanjutnya? Apakah ada syarat khusus untuk mengikuti pelatihan ini?	Pelatihan CCNA batch berikutnya dijadwalkan tanggal 5-7 Februari 2025 di Lab NCS Ruang B. Syarat: mahasiswa aktif semester 3 ke atas, sudah lulus mata kuliah Jaringan Komputer, dan membayar biaya pelatihan Rp 500.000 (sudah termasuk modul dan voucher ujian diskon 50%). Pendaftaran dibuka mulai 10 Januari 2025 melalui website lab. Kuota terbatas 30 peserta.	1	diterima	2024-12-10 09:15:00	2024-12-10 14:30:00	\N
25	Siti Nurhaliza	siti.nurhaliza@student.pnup.ac.id	Bagaimana cara mendapatkan akses lab untuk praktik di luar jam kuliah? Saya sedang mengerjakan tugas akhir tentang network security dan butuh akses ke perangkat Fortinet.	Untuk akses lab di luar jam kuliah, silakan submit form permohonan di website lab minimal 2 hari sebelumnya. Lampirkan surat tugas dari dosen pembimbing dan proposal TA. Akses diberikan Senin-Jumat pukul 16:00-20:00 dengan pendampingan asisten lab. Khusus penggunaan Fortinet FortiGate, Anda perlu ikut safety briefing terlebih dahulu (30 menit) karena perangkat produksi. Hubungi Pak Vipkas untuk jadwal briefing.	1	diterima	2024-12-08 10:22:00	2024-12-08 16:45:00	\N
26	Budi Santoso	budi.santoso@gmail.com	Saya dari komunitas IT luar kampus. Bolehkah meminjam proyektor dan router Mikrotik untuk seminar komunitas kami tanggal 20 Desember 2024?	\N	1	ditolak	2024-12-05 13:40:00	2024-12-05 15:10:00	Mohon maaf, peminjaman perangkat lab hanya untuk kegiatan internal kampus (mahasiswa/dosen PNUP) sesuai regulasi aset negara. Untuk acara eksternal, silakan hubungi Bagian Umum PNUP untuk peminjaman perangkat non-lab atau kerja sama resmi antar institusi.
27	Rina Amelia	rina.amelia@student.pnup.ac.id	Saya ingin konsultasi topik tugas akhir seputar IoT security. Apakah Lab NCS bisa bantu untuk riset dan pengujian? Kapan waktu yang tepat untuk bertemu dengan dosen lab?	\N	\N	menunggu	2024-12-14 08:30:00	\N	\N
28	Muhammad Rizki	rizki.m@student.pnup.ac.id	Laptop saya tidak support untuk install Kali Linux. Apakah boleh pakai laptop lab untuk praktikum ethical hacking? Bagaimana prosedurnya?	Ya, Anda bisa menggunakan 15 unit Laptop Asus ROG yang sudah ter-install Kali Linux, Metasploit, dan tools pentesting lainnya. Prosedur: (1) Daftar jadwal praktikum via website, (2) Tunjukkan KTM saat pinjam, (3) Maksimal 3 jam per sesi, (4) Laptop tidak boleh dibawa keluar lab. Data Anda akan tersimpan di user account, jadi bisa lanjut sesi berikutnya. Untuk save progress, gunakan cloud storage atau USB pribadi.	1	diterima	2024-12-12 11:05:00	2024-12-12 13:20:00	\N
29	Dedi Kusuma	dedi.k@yahoo.com	Saya mahasiswa semester 2 mau magang di Lab NCS untuk dapat pengalaman. Bisa langsung mulai besok?	\N	1	ditolak	2024-12-07 16:55:00	2024-12-08 09:00:00	Mohon maaf, magang di Lab NCS memerlukan: (1) Mahasiswa minimal semester 5, (2) IPK minimal 3.0, (3) Surat pengantar dari jurusan, (4) Proposal magang, (5) Rekomendasi dosen. Proses seleksi memakan waktu 2 minggu. Silakan lengkapi dokumen dan apply kembali saat memenuhi syarat. Info lengkap: labncs.pnup.ac.id/magang
30	Andi Prasetyo	andi.p@student.pnup.ac.id	Saya tertarik ikut kompetisi CTF tanggal 20 Februari 2025. Bagaimana cara daftar? Apakah ada pelatihan khusus untuk pemula?	Registrasi CTF dibuka 15 Januari 2025 di ctf.labncs.ac.id. Boleh daftar individu atau tim (max 3 orang). Untuk pemula, kami sediakan bootcamp CTF Fundamentals tanggal 25-27 Januari 2025 (gratis untuk mahasiswa PNUP, materi: web exploitation, cryptography, dan basic reverse engineering). Sangat disarankan ikut bootcamp dulu agar lebih siap. Pendaftaran bootcamp via website, kuota 50 peserta.	1	diterima	2024-12-11 14:18:00	2024-12-11 17:05:00	\N
31	Lisa Permata	lisa.permata@student.pnup.ac.id	Saya lupa password akun lab untuk akses server praktikum. Bagaimana cara reset? Apakah harus datang langsung ke lab?	\N	\N	menunggu	2024-12-14 15:42:00	\N	\N
\.


--
-- TOC entry 3563 (class 0 OID 20385)
-- Dependencies: 234
-- Data for Name: tbl_penelitian; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_penelitian (id_penelitian, judul_penelitian, tahun_penelitian, deskripsi_singkat, link_publikasi, file_dokumen_pdf, id_admin_pencatat, created_at, updated_at, anggota_luar) FROM stdin;
3	 Enhancing Mangrove Mapping in Malang Regency Through K-means Clustering	2024	Mangrove forests are vital for coastal defense, biodiversity preservation, and carbon storage. However, in urban areas like Greater Malang Region, the growth and sustainability of these forests are increasingly threatened by rapid urbanization and climate change. This study explores the growth patterns of mangrove trees in Malang by applying machine learning techniques, specifically clustering, to classify areas based on their urgency for intervention. By analyzing a dataset that includes various environmental and geographic characteristics of mangrove habitats in Malang, we employed the K-means algorithm to segment the data into 5 distinct clusters. These clusters not only reflect varying levels of urgency but also indicate that 2 out of the 5 clusters represent coastal areas requiring immediate and special intervention. The identification of these critical zones allows for targeted conservation efforts and the allocation of resources to the most affected regions. The findings demonstrate that clustering can effectively distinguish between areas with different levels of degradation and restoration needs, highlighting the utility of data-driven approaches in environmental management. This model offers a scalable solution for other urban regions facing similar ecological challenges.	https://scholar.google.com/citations?view_op=view_citation&hl=en&user=fjuEEzsAAAAJ&pagesize=100&sortby=pubdate&citation_for_view=fjuEEzsAAAAJ:LjlpjdlvIbIC	\N	\N	2025-12-07 22:36:52.10232	2025-12-14 21:06:17.16002	Nia Ambarsari, Faqih Hamami, Cahya Rahmad, Sinung Suakanto, Muhammad Auvi Amril
4	Remote Sensing Approach to Estimate Vegetation Aboveground Biomass Affected by Land Conversion in the Southern Area of Malang Regency	2025	Accurate estimation of vegetation Aboveground Biomass (AGB) is crucial for understanding carbon dynamics and supporting climate change mitigation strategies. This study explores the integration of remote sensing datasets and machine learning models to estimate AGB in South Malang Regency, Indonesia, a region characterized by diverse landscapes and ongoing infrastructure development. By utilizing GEDI L4A AGBD data as the target variable, and predictors derived from Sentinel-2 and Copernicus GLO-30 DEM, the study leverages Random Forest regression to generate precise biomass predictions. The results demonstrate the model's high predictive accuracy, with an RMSE of 34.719 and an R2 of 0.709, indicating strong alignment between observed and predicted values. The total estimated AGB for the study area in 2024 is approximately 34,003.34 Mg, reflecting minimal changes compared to prior years and suggesting balanced land-use dynamics. These findings underscore the potential of remote sensing and machine learning to provide actionable insights for sustainable forest management and land-use planning, particularly in regions undergoing rapid development.	https://scholar.google.com/citations?view_op=view_citation&hl=en&user=fjuEEzsAAAAJ&pagesize=100&sortby=pubdate&citation_for_view=fjuEEzsAAAAJ:VL0QpB8kHFEC	\N	\N	2025-12-07 22:37:25.633885	2025-12-14 20:59:51.502269	Aisya Rahma Rabbania, Sinung Suakanto, Faqih Hamami, Nia Ambarsari
6	The Genetic Diversity of Bali Sardinella (Sardinella lemuru) Caught at Bali Strait and Its Possible Relation to The Ocean Circulation	2025	Sardinella lemuru is known as the native pelagic fish of the Bali Strait. However, its \r\npresence has recently become challenging to find. This study aimed to validate S. lemuru \r\nusing molecular taxonomy and link it to water circulations for sustainable management. \r\nIt is the first study of relatively complete sequence data on S. lemuru in the Bali Strait. \r\nA total of 47 sequences were amplified using the control region gene of mitochondrial \r\nDNA. Other S. lemuru (n = 4) and Amblygaster sirm (n = 12) sequences were retrieved \r\nfrom GenBank. Low sequence divergence is observed in clade-1 of S. lemuru across the \r\nBali Strait, Manado-Sulawesi, and Kudat-Malaysia. This is probably due to its migration \r\nusing the main Indonesian ThroughFlow (ITF). There is an evolutionary divergence \r\nbetween two groups of S. lemurs, measuring 35.3%±4.1. The first signs of these cryptic \r\ngroups were found at Canggu and Prigi, with 87 base-pair differences between the two \r\ngroups. This study also presents strong evidence that A. sirm prefers overlapping water \r\nmass conditions with S. lemuru in the Bali Strait but is morphologically and genetically \r\ndistinct. Notably, three samples of A. sirm in Kedonganan-Bali are clustered with other \r\nA. sirm locations passed by the primary and secondary South China Sea throughflow. \r\nThe high genetic diversity of S. lemuru among Bali Strait sites demonstrates its \r\nadaptive ability, with scattered single-frequency haplotypes. The adaptive ability traits \r\nof S. lemuru support its stock recovery. The stock recovery recommendation is based \r\non finding S. lemuru’s adaptive traits within their populations in suitable habitats and \r\nclimatic conditions.	https://scholar.google.com/citations?view_op=view_citation&hl=en&user=fjuEEzsAAAAJ&pagesize=100&sortby=pubdate&citation_for_view=fjuEEzsAAAAJ:1yQoGdGgb4wC	penelitian_1765720637_2383.pdf	\N	2025-12-07 22:38:13.099098	2025-12-14 21:00:01.35804	Aida Sartimbul, I Gusti Ayu Diah Hendiari, I Wayan Arthana, Gde Raka Angga Kartika, Victor Adi Winata, Widodo Setiyo Pranowo, Raden Dwi Susanto, Nurul Muslihah, Defri Yona, Feni Iranawati
2	The Genetic Diversity of Bali Sardinella (Sardinella lemuru) Caught at Bali Strait and Its Possible Relation to The Ocean Circulation	2025	Sardinella lemuru is known as the native pelagic fish of the Bali Strait. However, its\r\npresence has recently become challenging to find. This study aimed to validate S. lemuru\r\nusing molecular taxonomy and link it to water circulations for sustainable management.\r\nIt is the first study of relatively complete sequence data on S. lemuru in the Bali Strait.\r\nA total of 47 sequences were amplified using the control region gene of mitochondrial\r\nDNA. Other S. lemuru (n = 4) and Amblygaster sirm (n = 12) sequences were retrieved\r\nfrom GenBank. Low sequence divergence is observed in clade-1 of S. lemuru across the\r\nBali Strait, Manado-Sulawesi, and Kudat-Malaysia. This is probably due to its migration\r\nusing the main Indonesian ThroughFlow (ITF). There is an evolutionary divergence\r\nbetween two groups of S. lemurs, measuring 35.3%±4.1. The first signs of these cryptic\r\ngroups were found at Canggu and Prigi, with 87 base-pair differences between the two\r\ngroups. This study also presents strong evidence that A. sirm prefers overlapping water\r\nmass conditions with S. lemuru in the Bali Strait but is morphologically and genetically\r\ndistinct. Notably, three samples of A. sirm in Kedonganan-Bali are clustered with other\r\nA. sirm locations passed by the primary and secondary South China Sea throughflow.\r\nThe high genetic diversity of S. lemuru among Bali Strait sites demonstrates its\r\nadaptive ability, with scattered single-frequency haplotypes. The adaptive ability traits\r\nof S. lemuru support its stock recovery. The stock recovery recommendation is based\r\non finding S. lemuru’s adaptive traits within their populations in suitable habitats and\r\nclimatic conditions.	https://scholar.google.com/citations?view_op=view_citation&hl=en&user=fjuEEzsAAAAJ&pagesize=100&sortby=pubdate&citation_for_view=fjuEEzsAAAAJ:1yQoGdGgb4wC	penelitian_1765721049_8178.pdf	\N	2025-12-07 22:36:31.13531	2025-12-14 21:04:09.815366	Aida Sartimbul, I Gusti Ayu Diah Hendiari, I Wayan Arthana, Gde Raka Angga Kartika, Victor Adi Winata, Widodo Setiyo Pranowo, Raden Dwi Susanto, Nurul Muslihah, Defri Yona, Feni Iranawati
9	Development of Geographical Information System for Mangrove Monitoring (Case Study: Mangrove Malang Indonesia)	2024	Mangrove monitoring is crucial in Kabupaten Malang, a region known for its 18 beaches. The increasing trend of mangrove deforestation, driven by unchecked tourism activities, underscores the need for an effective monitoring system. There is limited oversight from the government, which exacerbates the issue. This study aims to develop a geographical information system for a mangrove monitoring website that provides valuable insights to stakeholders while promoting awareness about eco-tourism practices. The project adopts the prototyping methodology within the software development life cycle to facilitate effective communication between researchers and expert users from Kabupaten Malang. The website was developed using the Django stack, a robust web development framework. User acceptance testing employed the Blackbox method, with results indicating that the system meets all defined use cases. Specifically, six use cases for administrators and three for guests were successfully validated, demonstrating the website's readiness for implementation as a pilot proj ect in Kabupaten Malang. The evaluation phase highlights opportunities for future enhancements, such as incorporating additional user roles to improve privacy and access control, integrating the platform with government systems for broader adoption, and embedding tutorial pages for user guidance. Additionally, real-time data integration from external resources is suggested to improve monitoring capabilities and encourage eco-tourism. These improvements aim to strengthen mangrove monitoring efforts and boost tourist engagement by emphasizing sustainable tourism practices. This initiative offers a promising step toward balancing ecological preservation and tourism development in Kabupaten Malang.	https://scholar.google.com/citations?view_op=view_citation&hl=en&user=fjuEEzsAAAAJ&pagesize=100&sortby=pubdate&citation_for_view=fjuEEzsAAAAJ:ye4kPcJQO24C	\N	\N	2025-12-13 18:45:13.072452	2025-12-14 21:05:19.441022	Safara Cathasa Riverinda Rijadi, Nia Ambarsari, Sinung Suakanto, Dita Pramesti, Faqih Hamami
10	Enhancing Road Repair Management in Indonesia Through Open Participatory Reporting Systems	2024	In Indonesia, roads are crucial for regional connectivity and economic growth. Effective road maintenance management is primarily managed by the Ministry of Public Works and Public Housing (PUPR) in collaboration with local governments, focusing on addressing forms of road deterioration such as potholes, cracking, rutting, and raveling. The open participatory model capitalizes on the high usage of mobile phones in Indonesia, projected to reach 97% by 2029, encouraging community participation in infrastructure management by enabling users to report road conditions in real-time using features such as GPS and camera functionality. The implementation of a digital map-based reporting system using OpenStreetMap and an AI-assisted mobile application enhances public involvement, fosters transparency, and improves road safety through real-time monitoring and efficient resource allocation by relevant authorities. This approach empowers citizens and promotes a safer traveling environment, ultimately contributing to better infrastructure management and community ownership.	https://scholar.google.com/citations?view_op=view_citation&hl=en&user=fjuEEzsAAAAJ&pagesize=100&sortby=pubdate&citation_for_view=fjuEEzsAAAAJ:WqliGbK-hY8C	\N	\N	2025-12-14 21:07:17.731655	2025-12-14 21:07:17.731655	Yan Watequlis Syaifudin, Amar Alpabet, Triana Fatmawati, Yuri Ariyanto, Pramana Yoga Saputra
8	A Review: Performance Analysis of Single Board Computer Technology as an IoT System	2025	The development of Internet of Things (IoT) technology has driven the demand for cost-effective server solutions capable of managing large volumes of data, thereby creating efficiencies in data management to support smart digitalization. Single Board Computer (SBC) technology, such as Raspberry Pi and Tinkerboard have been developed over the years to offer another alternative for powering energy efficient server infrastructure that has decent performance for diverse dataset processing for the IoT. Advantages provided by such devices make SBC a potential candidate for IoT servers. Such low-cost, low power machines can offer required computing resources to facilitate various IoT applications, such as edge processing, data aggregation and analysis. This paper compares single board computer products as IoT servers, such as Raspberry Pi 3, Raspberry Pi 4 and Asus Tinkerboard, from the case study of room sensor monitoring in Internet of Things. It can be seen from the test results that the Raspberry Pi 4 is more suitable to deploy IoT application at a low price when the CPU response time is 62 seconds, and the CPU response time is 96 seconds for the Raspberry Pi 3 and 64 seconds for the Tinker Board. This work will give useful advice to IoT developers, readers to choose an appropriate Single Board Computer for their environmental sensing work.	https://scholar.google.com/citations?view_op=view_citation&hl=en&user=fjuEEzsAAAAJ&pagesize=100&sortby=pubdate&citation_for_view=fjuEEzsAAAAJ:dQ2og3OwTAUC	penelitian_1765625610_3419.pdf	\N	2025-12-13 17:21:31.652059	2025-12-14 20:48:11.776165	Cahya Rahmad, Septian Enggar Sukmana, Aida Sartimbul, Kismet Anak Hong Ping, Annie Anak Joseph, Dayang Azra Awang Mat, Mohammad Faried Rahmat, Ahmad Afifuddin Zakki, Denny Nur Ramadhan
5	Spatial and Temporal Analysis of Mangrove and Forest Change Based on Pre-Segmented Land Cover Data in Malang Regency	2025	Effective monitoring of mangrove ecosystems is essential for their conservation and sustainable management. However, some regions may lack adequate remote sensing data due to factors such as temporal gaps, limited regional coverage, or suboptimal data quality, leading to reliance on available datasets. This study evaluates the Random Forest Classifier (RFC) for predicting land cover types across 16 coastal areas in Malang Regency using RGB-based land cover images. RFC achieved a high overall accuracy of up to 93% across three experiments, consistently demonstrating strong performance in identifying dominant classes, such as forest and mangroves, and outperforming the Convolutional Neural Network (CNN) model in accuracy. However, challenges were observed with minority classes, including forest loss and aquaculture ponds, reflecting the limitations of feature diversity and imbalanced data. These findings highlight the potential of RFC for analyzing land cover changes while emphasizing the importance of enhancing dataset quality and diversity to improve classification outcomes in underrepresented areas.	https://scholar.google.com/citations?view_op=view_citation&hl=en&user=fjuEEzsAAAAJ&pagesize=100&sortby=pubdate&citation_for_view=fjuEEzsAAAAJ:N5tVd3kTz84C	\N	\N	2025-12-07 22:37:51.625197	2025-12-14 20:59:57.193452	Danish Hasna Ayudya, Sinung Suakanto, Faqih Hamami, Nia Ambarsari
1	Integrasi Sistem Informasi Geografis dan Sistem Informasi Manajemen Keanggotaan untuk Meningkatkan Aksesibilitas Layanan Kesehatan pada Ikatan Dokter Indonesia (IDI) Cabang Malang Raya	2025	The Indonesian Medical Association (IDI) Chapter Malang Raya, which covers area of Malang City, Batu City, and Malang Regency, faces challenges in managing doctor membership data and presenting information related to customer services and public services.  To overcome these obstacles, a website-based information system was developed that integrates the Membership Management Information System with the Geographic Information System (GIS). The Membership Management Information System facilitates efficient management data of physician member of IDI chapter Malang Raya, including status of membership, competence of medical doctors, speciality, and subspeciality.  Whereas GIS system serves to map the location of doctor practices. Integration these two systems making it easier for people to find the nearest health services. The system was developed using the waterfall methodology, which involves the stages of requirements analysis, design, implementation, testing and maintenance. The result is a platform that can improve IDI's internal efficiency and make it easier for people to access health services.  This system has the potential to be further developed with the addition of security features and functionality such as real-time monitoring and mobile application integration, thus supporting more responsive and integrated health services.	https://scholar.google.com/citations?view_op=view_citation&hl=en&user=fjuEEzsAAAAJ&pagesize=100&sortby=pubdate&citation_for_view=fjuEEzsAAAAJ:9vf0nzSNQJEC	penelitian_1765720865_6879.pdf	\N	2025-11-27 10:10:23.200055	2025-12-14 21:01:16.83824	Imam Fahrur Rozi, Rudy Ariyanto, Rakhmat Arianto, Ratih Indri Hapsari, Ahmadi Yuli Ananta, Sasmojo Widito, Arief Syukron Zakaria, Arry Budiarti, Zainal Ulu Prima Saputra, Ferry Buyung Bakhtiar Irawan, Afifah Sholiha
7	MANGROVE MANAGEMENT INFORMATION SYSTEM IN SOUTHERN COAST OF MALANG INDONESIA USING TREND MOMENT METHOD.	2025	Objective: The objective of this study is to investigate mangrove changes using satellite image from 2018 to 2023, then compared with in situ data in 2024 with the aim of developing an information system on mangrove vegetation of 18 beaches in Southern Coast of Malang, East Java, Indonesia. Theoretical Framework: In this topic, the main concepts and theories that underpin the research are presented. The digital image processing techniques previously employed by (Yang et al., 2022) and prediction theory by using trend of moment presented by previous work stand out, providing a solid basis for understanding the context of the investigation. Method: This research was conducted at 18 points across South Malang Regency, covering various beach locations with different mangrove ecosystem characteristics. The study uses the Trend Moment method to monitor changes in mangrove vegetation, with data from 2018 to 2023 compared to field observations. The results, presented in numerical form, graphs, and maps, help identify changes and provide recommendations for conservation actions at each location. Results and Discussion: The mangrove management information system in Southern Coast of Malang, Indonesia, using the Trend Moment Method, tracks changes in mangrove biota. The study's final results are applicable and can be utilized by stakeholders, offering valuable recommendations for managing mangrove biota. These findings can also be implemented in other coastal areas of the southern part of Java Island. Research Implications: The practical and theoretical implications of this research are discussed, providing insights into how the results can be applied or influence practices in the field of coastal management, information systems and dynamic coastal ecosystem. These implications could encompass of mangrove vegetation, satellite image processing, marine ecosystem, coastal management. Originality/Value: The mangrove changes of 18 beaches in Southern Coast of Malang, East Java, Indonesia is heavily affected by changes function as transportation routes.	https://scholar.google.com/citations?view_op=view_citation&hl=en&user=fjuEEzsAAAAJ&pagesize=100&sortby=pubdate&citation_for_view=fjuEEzsAAAAJ:PR6Y55bgFSsC	\N	\N	2025-12-07 22:38:31.387845	2025-12-14 21:00:04.808813	Gisanda Aliya Ramadhanty, Cahya Rahmad, Nia Ambarsari, Putri Maulida Sito Resmi, Faqih Hamami
\.


--
-- TOC entry 3564 (class 0 OID 20392)
-- Dependencies: 235
-- Data for Name: tbl_penelitian_anggota; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_penelitian_anggota (id_penelitian, id_pengelola) FROM stdin;
8	9
4	9
4	10
4	12
5	9
6	9
7	9
1	9
2	9
9	9
3	9
10	9
\.


--
-- TOC entry 3566 (class 0 OID 20396)
-- Dependencies: 237
-- Data for Name: tbl_pengabdian; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_pengabdian (id_pengabdian, judul_kegiatan, tahun_kegiatan, deskripsi_kegiatan, file_dokumen_pdf, id_admin_pencatat, created_at, updated_at, anggota_luar) FROM stdin;
5	Implementasi Framework Zero Trust Architecture untuk Keamanan Jaringan Kampus di Era Digital	2024	Pengabdian ini mengimplementasikan framework Zero Trust Architecture (ZTA) pada jaringan kampus sebagai solusi keamanan modern menghadapi ancaman siber yang semakin kompleks. Berdasarkan model NIST SP 800-207, implementasi ini menerapkan prinsip "never trust, always verify" dengan micro-segmentation, identity-based access control, dan continuous monitoring. Sistem yang dikembangkan mengintegrasikan Multi-Factor Authentication (MFA), Software-Defined Perimeter (SDP), dan real-time threat detection menggunakan machine learning. Hasil implementasi menunjukkan pengurangan 87% terhadap lateral movement attacks dan peningkatan 95% dalam deteksi anomali jaringan. Proyek ini juga mengembangkan dashboard monitoring terpusat yang memberikan visibility end-to-end terhadap seluruh traffic jaringan, dengan capability untuk automated response terhadap threat indicators. Implementasi ZTA ini menjadi model referensi untuk institusi pendidikan yang ingin meningkatkan postur keamanan jaringan mereka sesuai dengan standar internasional.	pengabdian_1765721896.pdf	1	2025-12-14 21:18:16.638169	2025-12-14 21:18:16.638169	Dr. Muhammad Rizki (Universitas Indonesia), Prof. Sarah Chen (Stanford University)
2	Pengembangan Sistem Deteksi Intrusi Berbasis Deep Learning untuk Keamanan IoT Networks di Smart City	2024	Penelitian ini mengembangkan Intrusion Detection System (IDS) inovatif menggunakan arsitektur deep learning untuk mengatasi tantangan keamanan pada IoT networks dalam ekosistem smart city. Sistem yang dikembangkan mengimplementasikan Convolutional Neural Networks (CNN) dan Long Short-Term Memory (LSTM) untuk menganalisis pola traffic dan mendeteksi anomali secara real-time. Dataset yang digunakan mencakup NSL-KDD, UNSW-NB15, dan custom dataset dari implementasi IoT lokal. Model mencapai akurasi 98.7% dalam mendeteksi berbagai jenis serangan termasuk DDoS, Man-in-the-Middle, dan botnet attacks. Sistem dilengkapi dengan mekanisme adaptive learning yang dapat memperbaharui model deteksi berdasarkan threat intelligence terbaru. Implementasi field trial pada 500+ IoT devices menunjukkan false positive rate hanya 1.2% dengan latency deteksi rata-rata 0.8 detik. Solusi ini juga terintegrasi dengan SIEM platform untuk automated incident response dan forensic analysis.	pengabdian_1765721946.pdf	1	2025-11-26 13:48:08.077078	2025-11-26 13:48:08.077078	Dr. Ahmad Fauzi (Institut Teknologi Bandung), Dr. Lisa Wang (MIT Media Lab)
6	Implementasi Sistem Autentikasi Terdesentralisasi Berbasis Blockchain untuk Layanan E-Government	2023	Pengabdian ini merancang dan mengimplementasikan sistem autentikasi terdesentralisasi menggunakan teknologi blockchain untuk meningkatkan keamanan dan privasi layanan e-government. Sistem menggunakan Hyperledger Fabric sebagai platform blockchain dengan smart contract untuk manajemen identitas digital yang immutable dan auditable. Implementasi Self-Sovereign Identity (SSI) memungkinkan warga negara memiliki kontrol penuh terhadap data pribadi mereka dengan verifiable credentials yang dapat digunakan across multiple government services. Sistem dilengkapi dengan biometric authentication dan zero-knowledge proof untuk privacy-preserving verification. Pilot project pada 3 layanan pemerintah menunjukkan pengurangan 76% dalam kasus identity fraud dan peningkatan 92% dalam user trust scores. Transaction throughput mencapai 5000 TPS dengan finality time 2.3 detik. Arsitektur yang dikembangkan juga memenuhi compliance terhadap GDPR dan standar keamanan ISO 27001.	pengabdian_1765721985.pdf	1	2025-12-14 21:19:45.398352	2025-12-14 21:19:45.398352	Prof. David Miller (Carnegie Mellon University), Dr. Cahya Damarjati (Universitas Gadjah Mada)
7	Pengembangan Advanced Threat Hunting Platform Menggunakan AI-Powered Analytics dan Behavioral Analysis	2024	Penelitian ini mengembangkan platform threat hunting generasi baru yang mengintegrasikan artificial intelligence, behavioral analysis, dan threat intelligence untuk proactive threat detection. Platform menggunakan ensemble learning algorithms yang menggabungkan Random Forest, XGBoost, dan Neural Networks untuk menganalisis endpoint telemetry, network traffic, dan user behavior patterns. Sistem dilengkapi dengan automated threat hypothesis generation menggunakan Natural Language Processing (NLP) terhadap global threat intelligence feeds. User and Entity Behavior Analytics (UEBA) engine dapat mendeteksi insider threats dan Advanced Persistent Threats (APT) dengan precision rate 94.3%. Platform juga mengimplementasikan MITRE ATT&CK framework untuk tactical mapping dan automated playbook execution. Field deployment pada enterprise environment menunjukkan Mean Time to Detect (MTTD) berkurang dari 206 hari menjadi 8.2 jam, dengan 89% reduction dalam false positives. Dashboard interaktif menyediakan threat visualization dan automated reporting untuk compliance requirements.	pengabdian_1765722019.pdf	1	2025-12-14 21:20:19.1047	2025-12-14 21:20:19.1047	Dr. Kevin Mitnick Memorial Research Group, Prof. Yuki Tanaka (University of Tokyo)
8	Implementasi Post-Quantum Cryptography untuk Keamanan Sistem Finansial di Era Quantum Computing	2023	Pengabdian ini mengimplementasikan algoritma kriptografi yang resisten terhadap serangan quantum computer pada sistem finansial untuk mengantisipasi ancaman era quantum computing. Implementasi menggunakan NIST Post-Quantum Cryptography standardization algorithms termasuk CRYSTALS-Kyber untuk key encapsulation dan CRYSTALS-Dilithium untuk digital signatures. Sistem hybrid cryptography menggabungkan classical algorithms (RSA, ECC) dengan post-quantum algorithms untuk backward compatibility dan future-proof security. Performance evaluation menunjukkan overhead computation hanya 12-18% dibanding classical cryptography namun memberikan security margin terhadap quantum attacks dengan estimated 256-bit quantum security level. Implementasi pada payment gateway dan core banking systems berhasil memproses 100,000+ transactions per second dengan latency tambahan < 5ms. Sistem juga dilengkapi dengan crypto-agility architecture yang memungkinkan seamless algorithm migration seiring dengan evolusi standar PQC. Proyek ini menjadi pioneer implementation di Indonesia untuk quantum-safe financial infrastructure.	pengabdian_1765722055.pdf	1	2025-12-14 21:20:55.930525	2025-12-14 21:20:55.930525	Prof. Peter Shor (MIT), Dr. Budi Rahardjo (Institut Teknologi Bandung)
9	Pengembangan Security Framework untuk Software-Defined Networking pada Modern Data Centers	2024	Penelitian ini merancang comprehensive security framework untuk Software-Defined Networking (SDN) environments pada modern data centers. Framework mengimplementasikan defense-in-depth approach dengan security controls pada control plane, data plane, dan application plane. Sistem mengintegrasikan FlowVisor untuk network virtualization security, OpenFlow protocol hardening, dan controller redundancy untuk high availability. Security features mencakup dynamic access control lists (ACL), automated threat mitigation, dan distributed denial-of-service (DDoS) protection dengan traffic scrubbing capability hingga 100 Gbps. Machine learning algorithms digunakan untuk anomaly detection pada flow tables dan controller communications. Implementasi pada production data center dengan 5000+ servers menunjukkan 99.99% uptime, reduction 94% dalam lateral movement attempts, dan automated mitigation time < 30 detik untuk known attack patterns. Framework juga menyediakan centralized security policy management dengan multi-tenancy isolation dan compliance reporting untuk regulatory requirements.	pengabdian_1765722084.pdf	1	2025-12-14 21:21:24.827601	2025-12-14 21:21:24.827601	Dr. Nick McKeown (Stanford University), Dr. Riri Fitri Sari (Universitas Indonesia)
10	Implementasi Cloud Security Posture Management dengan Automated Compliance untuk Multi-Cloud Environments	2024	Pengabdian ini mengembangkan Cloud Security Posture Management (CSPM) platform yang comprehensive untuk mengelola keamanan pada multi-cloud environments (AWS, Azure, GCP). Sistem mengimplementasikan continuous compliance monitoring terhadap 150+ security standards termasuk CIS Benchmarks, PCI-DSS, HIPAA, dan ISO 27001. Automated remediation engine dapat memperbaiki 78% misconfigurations secara otomatis menggunakan Infrastructure as Code (IaC) templates. Platform dilengkapi dengan cloud workload protection yang mencakup vulnerability scanning, malware detection, dan runtime application self-protection (RASP). Machine learning models menganalisis cloud audit logs untuk mendeteksi suspicious activities dan potential data exfiltration dengan accuracy 96.8%. Integration dengan SIEM dan SOAR platforms memungkinkan orchestrated incident response across multiple cloud providers. Dashboard menyediakan unified security view dengan risk scoring, trend analysis, dan executive reporting. Pilot implementation menunjukkan 83% reduction dalam security misconfiguration incidents dan 91% improvement dalam compliance audit readiness.	pengabdian_1765722126.pdf	1	2025-12-14 21:22:06.556947	2025-12-14 21:22:06.556947	Dr. Werner Vogels (Amazon CTO), Dr. Indra Gunawan (Telkom University)
11	Implementasi Privacy-Preserving Machine Learning untuk Secure Healthcare Data Analytics	2023	Penelitian ini mengimplementasikan privacy-preserving machine learning techniques untuk healthcare data analytics yang memenuhi strict privacy regulations (HIPAA, GDPR). Sistem menggunakan federated learning architecture yang memungkinkan collaborative model training across multiple hospitals tanpa raw data sharing. Differential privacy mechanisms diterapkan dengan epsilon budget optimization untuk menjaga patient privacy sambil maintaining model utility. Homomorphic encryption digunakan untuk computation on encrypted data, memungkinkan predictive analytics tanpa decryption. Secure multi-party computation (MPC) protocols memfasilitasi joint statistical analysis dengan cryptographic guarantees. Implementation pada 12 rumah sakit dengan 2.5 juta patient records menunjukkan model accuracy 94.1% untuk disease prediction dengan privacy loss bounded by epsilon=1.0. System throughput mencapai 50,000 encrypted inference requests per second dengan end-to-end latency < 200ms. Platform juga menyediakan audit trail yang tamper-proof untuk regulatory compliance dan patient consent management.	pengabdian_1765722164.pdf	1	2025-12-14 21:22:44.536256	2025-12-14 21:22:44.536256	Prof. Cynthia Dwork (Harvard University), Dr. Adi Utarini (Universitas Gadjah Mada)
12	Pengembangan Next-Generation Firewall dengan Real-Time Threat Intelligence Integration dan ML-Based Filtering	2024	Pengabdian ini mengembangkan Next-Generation Firewall (NGFW) dengan capabilities yang melampaui traditional packet filtering melalui deep packet inspection, application awareness, dan integrated threat prevention. Sistem mengintegrasikan multiple threat intelligence feeds (MISP, AlienVault OTX, VirusTotal) dengan correlation engine untuk real-time threat contextualization. Machine learning classifier menggunakan ensemble methods untuk encrypted traffic analysis tanpa decryption, achieving 97.2% accuracy dalam detecting malicious encrypted traffic. Advanced features mencakup SSL/TLS inspection dengan certificate pinning validation, intrusion prevention system (IPS) dengan 45,000+ signatures, dan sandboxing untuk zero-day threat analysis. Geo-IP filtering, reputation-based blocking, dan botnet C&C detection memberikan multi-layered defense. Performance testing menunjukkan throughput 40 Gbps dengan latency < 2ms dan concurrent connection handling hingga 10 juta sessions. Management plane menyediakan centralized policy orchestration, automated rule optimization, dan comprehensive logging untuk forensic analysis.	pengabdian_1765722196.pdf	1	2025-12-14 21:23:16.131911	2025-12-14 21:23:16.131911	Dr. Marcus Ranum (Firewall Pioneer), Dr. Kuspriyanto (Institut Teknologi Bandung)
13	Implementasi Secure DevSecOps Pipeline dengan Automated Security Testing dan Continuous Compliance	2024	Penelitian ini merancang dan mengimplementasikan comprehensive DevSecOps pipeline yang mengintegrasikan security automation pada setiap tahap software development lifecycle. Pipeline menggunakan shift-left security approach dengan automated security testing tools: SonarQube untuk static application security testing (SAST), OWASP Dependency-Check untuk software composition analysis (SCA), dan Trivy untuk container image scanning. Dynamic application security testing (DAST) dilakukan menggunakan OWASP ZAP dengan selenium-based automated crawling. Infrastructure as Code (IaC) security scanning menggunakan Checkov dan tfsec untuk detecting misconfigurations sebelum deployment. Secrets management terintegrasi dengan HashiCorp Vault dengan dynamic credentials rotation. Policy as Code implementation menggunakan Open Policy Agent (OPA) untuk enforcing security policies pada deployment pipeline. Container runtime security menggunakan Falco untuk detecting anomalous behaviors. Implementation menunjukkan 89% reduction dalam security vulnerabilities reaching production, mean time to remediation turun dari 28 hari ke 4.2 hari, dan 100% compliance dengan security policies. CI/CD pipeline dapat memproses 200+ deployments per day dengan automated security gates.	pengabdian_1765722222.pdf	1	2025-12-14 21:23:42.364436	2025-12-14 21:23:42.364436	Gene Kim (DevOps Research and Assessment), Dr. Husni Thamrin (Universitas Indonesia)
\.


--
-- TOC entry 3567 (class 0 OID 20403)
-- Dependencies: 238
-- Data for Name: tbl_pengabdian_anggota; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_pengabdian_anggota (id_pengabdian, id_pengelola) FROM stdin;
5	9
5	10
5	11
2	9
2	12
2	13
6	9
6	10
6	11
7	9
7	10
7	13
8	9
8	11
8	12
9	10
9	11
9	13
10	9
10	10
10	12
11	9
11	11
11	12
12	9
12	11
12	13
13	9
13	10
13	11
\.


--
-- TOC entry 3569 (class 0 OID 20407)
-- Dependencies: 240
-- Data for Name: tbl_pengelola; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_pengelola (id_pengelola, nama_pengelola, foto_pengelola, id_admin_pencatat, created_at, updated_at, nid_nip, id_jabatan, linkedin_url) FROM stdin;
10	Ade Ismail, S.Kom., M.TI	berita_1765119275_7284.jpg	1	2025-12-07 21:54:35.338018	2025-12-07 21:54:35.338018	199107042019031021	6	\N
11	Sofyan Noor Arief, S.ST., M.Kom.	berita_1765119302_3363.jpg	1	2025-12-07 21:55:02.599721	2025-12-07 21:55:02.599721	198908132019031017	6	\N
12	Meyti Eka Apriyani ST., MT.	berita_1765119334_9837.jpg	1	2025-12-07 21:55:34.13138	2025-12-07 21:55:34.13138	198704242019032017	6	\N
13	Vipkas Al Hadid Firdaus, ST,. MT	berita_1765119365_9812.jpg	1	2025-12-07 21:56:05.793883	2025-12-07 21:56:05.793883	199105052019031029	6	\N
9	Erfan Rohadi, ST., M.Eng., Ph.D.	berita_1765119246_9837.jpg	1	2025-12-07 21:54:06.610979	2025-12-07 21:54:06.610979	197201232008011006	1	\N
\.


--
-- TOC entry 3571 (class 0 OID 20417)
-- Dependencies: 242
-- Data for Name: tbl_pengelola_keminatan; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_pengelola_keminatan (id_pengelola_keminatan, id_pengelola, id_keminatan, created_at) FROM stdin;
18	10	1	2025-12-07 21:54:35.341061
19	10	2	2025-12-07 21:54:35.342629
20	11	11	2025-12-07 21:55:02.602842
21	12	1	2025-12-07 21:55:34.139386
22	12	14	2025-12-07 21:55:34.140958
23	12	11	2025-12-07 21:55:34.141604
24	12	15	2025-12-07 21:55:34.14224
25	13	13	2025-12-07 21:56:05.797308
26	13	2	2025-12-07 21:56:05.798521
27	13	12	2025-12-07 21:56:05.799274
28	13	4	2025-12-07 21:56:05.800188
29	9	10	2025-12-08 13:58:19.915228
30	9	11	2025-12-08 13:58:19.923871
31	9	4	2025-12-08 13:58:19.926066
32	9	9	2025-12-08 13:58:19.927681
\.


--
-- TOC entry 3573 (class 0 OID 20422)
-- Dependencies: 244
-- Data for Name: tbl_sarana_prasarana; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tbl_sarana_prasarana (id_sarana, nama_sarana, deskripsi_sarana, foto_sarana, jumlah, kondisi, id_admin_pencatat, created_at, updated_at) FROM stdin;
1	Server Dell PowerEdge R740	Server enterprise untuk virtualisasi lab, dilengkapi dual Intel Xeon Gold 6130, RAM 128GB, dan storage 4TB SSD RAID 10.	sarana_1765733606_1967.jpg	2	Baik	1	2025-12-15 00:33:10.440855	2025-12-15 00:33:10.440855
2	Mikrotik CCR1036-12G-4S	Router enterprise untuk praktikum jaringan tingkat lanjut, mendukung throughput hingga 24 Gbps dan fitur OSPF, BGP, MPLS.	sarana_1765733613_5194.jpg	5	Baik	1	2025-12-15 00:33:10.440855	2025-12-15 00:33:10.440855
3	Cisco Catalyst 2960X Switch	Switch managed 24-port Gigabit untuk topologi jaringan kompleks, mendukung VLAN, STP, dan port security.	sarana_1765733621_2359.jpg	8	Baik	1	2025-12-15 00:33:10.440855	2025-12-15 00:33:10.440855
4	Laptop Asus ROG Strix G15	Laptop untuk mahasiswa praktikum penetration testing, spesifikasi AMD Ryzen 7 5800H, RTX 3060, RAM 16GB, SSD 512GB.	sarana_1765733628_4498.jpg	15	Baik	1	2025-12-15 00:33:10.440855	2025-12-15 00:33:10.440855
5	Access Point Ubiquiti UniFi 6 LR	Access point WiFi 6 untuk coverage lab, mendukung 300+ concurrent clients dengan kecepatan hingga 3 Gbps.	sarana_1765733635_6751.jpg	10	Baik	1	2025-12-15 00:33:10.440855	2025-12-15 00:33:10.440855
6	Firewall Fortinet FortiGate 60F	Next-generation firewall untuk praktikum keamanan jaringan, dilengkapi IPS/IDS, VPN, dan web filtering.	sarana_1765733644_6729.jpg	3	Baik	1	2025-12-15 00:33:10.440855	2025-12-15 00:33:10.440855
7	Raspberry Pi 4 Model B	Single-board computer untuk IoT dan embedded systems, RAM 8GB, WiFi dual-band, Bluetooth 5.0.	sarana_1765733652_3126.jpg	20	Baik	1	2025-12-15 00:33:10.440855	2025-12-15 00:33:10.440855
8	Kabel UTP Cat6 305m	Kabel jaringan gigabit ethernet untuk instalasi lab, sertifikasi TIA/EIA-568-B, shielded.	sarana_1765733659_1708.jpg	25	Baik	1	2025-12-15 00:33:10.440855	2025-12-15 00:33:10.440855
9	Projector Epson EB-2250U	Proyektor WUXGA 5000 lumens untuk ruang seminar dan presentasi, dilengkapi wireless mirroring.	sarana_1765733666_7277.jpg	4	Baik	1	2025-12-15 00:33:10.440855	2025-12-15 00:33:10.440855
10	Camera IP Hikvision DS-2CD2143G0-I	Kamera IP 4MP untuk CCTV lab dan praktikum surveillance, night vision 30m, PoE enabled.	sarana_1765733672_1676.jpg	12	Baik	1	2025-12-15 00:33:10.440855	2025-12-15 00:33:10.440855
\.


--
-- TOC entry 3598 (class 0 OID 0)
-- Dependencies: 215
-- Name: tbl_admin_id_admin_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_admin_id_admin_seq', 9, true);


--
-- TOC entry 3599 (class 0 OID 0)
-- Dependencies: 217
-- Name: tbl_agenda_id_agenda_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_agenda_id_agenda_seq', 22, true);


--
-- TOC entry 3600 (class 0 OID 0)
-- Dependencies: 219
-- Name: tbl_arsip_id_dokumen_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_arsip_id_dokumen_seq', 3, true);


--
-- TOC entry 3601 (class 0 OID 0)
-- Dependencies: 221
-- Name: tbl_berita_id_berita_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_berita_id_berita_seq', 40, true);


--
-- TOC entry 3602 (class 0 OID 0)
-- Dependencies: 223
-- Name: tbl_galeri_id_foto_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_galeri_id_foto_seq', 9, true);


--
-- TOC entry 3603 (class 0 OID 0)
-- Dependencies: 225
-- Name: tbl_halaman_statis_id_halaman_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_halaman_statis_id_halaman_seq', 1, false);


--
-- TOC entry 3604 (class 0 OID 0)
-- Dependencies: 227
-- Name: tbl_jabatan_id_jabatan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_jabatan_id_jabatan_seq', 10, true);


--
-- TOC entry 3605 (class 0 OID 0)
-- Dependencies: 229
-- Name: tbl_kategori_arsip_id_kategori_arsip_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_kategori_arsip_id_kategori_arsip_seq', 5, true);


--
-- TOC entry 3606 (class 0 OID 0)
-- Dependencies: 231
-- Name: tbl_keminatan_id_keminatan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_keminatan_id_keminatan_seq', 15, true);


--
-- TOC entry 3607 (class 0 OID 0)
-- Dependencies: 233
-- Name: tbl_konsultasi_id_konsultasi_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_konsultasi_id_konsultasi_seq', 31, true);


--
-- TOC entry 3608 (class 0 OID 0)
-- Dependencies: 236
-- Name: tbl_penelitian_id_penelitian_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_penelitian_id_penelitian_seq', 10, true);


--
-- TOC entry 3609 (class 0 OID 0)
-- Dependencies: 239
-- Name: tbl_pengabdian_id_pengabdian_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_pengabdian_id_pengabdian_seq', 13, true);


--
-- TOC entry 3610 (class 0 OID 0)
-- Dependencies: 241
-- Name: tbl_pengelola_id_pengelola_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_pengelola_id_pengelola_seq', 15, true);


--
-- TOC entry 3611 (class 0 OID 0)
-- Dependencies: 243
-- Name: tbl_pengelola_keminatan_id_pengelola_keminatan_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_pengelola_keminatan_id_pengelola_keminatan_seq', 43, true);


--
-- TOC entry 3612 (class 0 OID 0)
-- Dependencies: 245
-- Name: tbl_sarana_prasarana_id_sarana_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tbl_sarana_prasarana_id_sarana_seq', 10, true);


--
-- TOC entry 3333 (class 2606 OID 20467)
-- Name: tbl_admin tbl_admin_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_admin
    ADD CONSTRAINT tbl_admin_pkey PRIMARY KEY (id_admin);


--
-- TOC entry 3335 (class 2606 OID 20469)
-- Name: tbl_admin tbl_admin_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_admin
    ADD CONSTRAINT tbl_admin_username_key UNIQUE (email);


--
-- TOC entry 3337 (class 2606 OID 20471)
-- Name: tbl_agenda tbl_agenda_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_agenda
    ADD CONSTRAINT tbl_agenda_pkey PRIMARY KEY (id_agenda);


--
-- TOC entry 3339 (class 2606 OID 20473)
-- Name: tbl_arsip tbl_arsip_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_arsip
    ADD CONSTRAINT tbl_arsip_pkey PRIMARY KEY (id_dokumen);


--
-- TOC entry 3341 (class 2606 OID 20475)
-- Name: tbl_berita tbl_berita_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_berita
    ADD CONSTRAINT tbl_berita_pkey PRIMARY KEY (id_berita);


--
-- TOC entry 3343 (class 2606 OID 20477)
-- Name: tbl_berita tbl_berita_slug_berita_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_berita
    ADD CONSTRAINT tbl_berita_slug_berita_key UNIQUE (slug_berita);


--
-- TOC entry 3345 (class 2606 OID 20479)
-- Name: tbl_galeri tbl_galeri_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_galeri
    ADD CONSTRAINT tbl_galeri_pkey PRIMARY KEY (id_foto);


--
-- TOC entry 3347 (class 2606 OID 20481)
-- Name: tbl_halaman_statis tbl_halaman_statis_key_halaman_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_halaman_statis
    ADD CONSTRAINT tbl_halaman_statis_key_halaman_key UNIQUE (key_halaman);


--
-- TOC entry 3349 (class 2606 OID 20483)
-- Name: tbl_halaman_statis tbl_halaman_statis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_halaman_statis
    ADD CONSTRAINT tbl_halaman_statis_pkey PRIMARY KEY (id_halaman);


--
-- TOC entry 3351 (class 2606 OID 20485)
-- Name: tbl_jabatan tbl_jabatan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_jabatan
    ADD CONSTRAINT tbl_jabatan_pkey PRIMARY KEY (id_jabatan);


--
-- TOC entry 3353 (class 2606 OID 20487)
-- Name: tbl_kategori_arsip tbl_kategori_arsip_nama_kategori_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_kategori_arsip
    ADD CONSTRAINT tbl_kategori_arsip_nama_kategori_key UNIQUE (nama_kategori);


--
-- TOC entry 3355 (class 2606 OID 20489)
-- Name: tbl_kategori_arsip tbl_kategori_arsip_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_kategori_arsip
    ADD CONSTRAINT tbl_kategori_arsip_pkey PRIMARY KEY (id_kategori_arsip);


--
-- TOC entry 3357 (class 2606 OID 20491)
-- Name: tbl_keminatan tbl_keminatan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_keminatan
    ADD CONSTRAINT tbl_keminatan_pkey PRIMARY KEY (id_keminatan);


--
-- TOC entry 3359 (class 2606 OID 20493)
-- Name: tbl_konsultasi tbl_konsultasi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_konsultasi
    ADD CONSTRAINT tbl_konsultasi_pkey PRIMARY KEY (id_konsultasi);


--
-- TOC entry 3363 (class 2606 OID 20495)
-- Name: tbl_penelitian_anggota tbl_penelitian_anggota_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_penelitian_anggota
    ADD CONSTRAINT tbl_penelitian_anggota_pkey PRIMARY KEY (id_penelitian, id_pengelola);


--
-- TOC entry 3361 (class 2606 OID 20497)
-- Name: tbl_penelitian tbl_penelitian_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_penelitian
    ADD CONSTRAINT tbl_penelitian_pkey PRIMARY KEY (id_penelitian);


--
-- TOC entry 3367 (class 2606 OID 20499)
-- Name: tbl_pengabdian_anggota tbl_pengabdian_anggota_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengabdian_anggota
    ADD CONSTRAINT tbl_pengabdian_anggota_pkey PRIMARY KEY (id_pengabdian, id_pengelola);


--
-- TOC entry 3365 (class 2606 OID 20501)
-- Name: tbl_pengabdian tbl_pengabdian_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengabdian
    ADD CONSTRAINT tbl_pengabdian_pkey PRIMARY KEY (id_pengabdian);


--
-- TOC entry 3374 (class 2606 OID 20503)
-- Name: tbl_pengelola_keminatan tbl_pengelola_keminatan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengelola_keminatan
    ADD CONSTRAINT tbl_pengelola_keminatan_pkey PRIMARY KEY (id_pengelola_keminatan);


--
-- TOC entry 3370 (class 2606 OID 20505)
-- Name: tbl_pengelola tbl_pengelola_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengelola
    ADD CONSTRAINT tbl_pengelola_pkey PRIMARY KEY (id_pengelola);


--
-- TOC entry 3378 (class 2606 OID 20507)
-- Name: tbl_sarana_prasarana tbl_sarana_prasarana_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_sarana_prasarana
    ADD CONSTRAINT tbl_sarana_prasarana_pkey PRIMARY KEY (id_sarana);


--
-- TOC entry 3376 (class 2606 OID 20509)
-- Name: tbl_pengelola_keminatan unique_pengelola_keminatan; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengelola_keminatan
    ADD CONSTRAINT unique_pengelola_keminatan UNIQUE (id_pengelola, id_keminatan);


--
-- TOC entry 3368 (class 1259 OID 20510)
-- Name: idx_pengelola_jabatan; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_pengelola_jabatan ON public.tbl_pengelola USING btree (id_jabatan);


--
-- TOC entry 3371 (class 1259 OID 20511)
-- Name: idx_pengelola_keminatan_keminatan; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_pengelola_keminatan_keminatan ON public.tbl_pengelola_keminatan USING btree (id_keminatan);


--
-- TOC entry 3372 (class 1259 OID 20512)
-- Name: idx_pengelola_keminatan_pengelola; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_pengelola_keminatan_pengelola ON public.tbl_pengelola_keminatan USING btree (id_pengelola);


--
-- TOC entry 3331 (class 1259 OID 20513)
-- Name: idx_reset_token; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_reset_token ON public.tbl_admin USING btree (reset_token);


--
-- TOC entry 3380 (class 2606 OID 20514)
-- Name: tbl_arsip fk_kategori_arsip; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_arsip
    ADD CONSTRAINT fk_kategori_arsip FOREIGN KEY (id_kategori_arsip) REFERENCES public.tbl_kategori_arsip(id_kategori_arsip) ON DELETE SET NULL;


--
-- TOC entry 3394 (class 2606 OID 20519)
-- Name: tbl_pengelola_keminatan fk_keminatan; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengelola_keminatan
    ADD CONSTRAINT fk_keminatan FOREIGN KEY (id_keminatan) REFERENCES public.tbl_keminatan(id_keminatan) ON DELETE CASCADE;


--
-- TOC entry 3395 (class 2606 OID 20524)
-- Name: tbl_pengelola_keminatan fk_pengelola; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengelola_keminatan
    ADD CONSTRAINT fk_pengelola FOREIGN KEY (id_pengelola) REFERENCES public.tbl_pengelola(id_pengelola) ON DELETE CASCADE;


--
-- TOC entry 3392 (class 2606 OID 20529)
-- Name: tbl_pengelola fk_pengelola_jabatan; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengelola
    ADD CONSTRAINT fk_pengelola_jabatan FOREIGN KEY (id_jabatan) REFERENCES public.tbl_jabatan(id_jabatan) ON DELETE SET NULL;


--
-- TOC entry 3379 (class 2606 OID 20534)
-- Name: tbl_agenda tbl_agenda_id_admin_penulis_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_agenda
    ADD CONSTRAINT tbl_agenda_id_admin_penulis_fkey FOREIGN KEY (id_admin_penulis) REFERENCES public.tbl_admin(id_admin) ON DELETE SET NULL;


--
-- TOC entry 3381 (class 2606 OID 20539)
-- Name: tbl_arsip tbl_arsip_id_admin_uploader_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_arsip
    ADD CONSTRAINT tbl_arsip_id_admin_uploader_fkey FOREIGN KEY (id_admin_uploader) REFERENCES public.tbl_admin(id_admin) ON DELETE SET NULL;


--
-- TOC entry 3382 (class 2606 OID 20544)
-- Name: tbl_berita tbl_berita_id_admin_penulis_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_berita
    ADD CONSTRAINT tbl_berita_id_admin_penulis_fkey FOREIGN KEY (id_admin_penulis) REFERENCES public.tbl_admin(id_admin) ON DELETE SET NULL;


--
-- TOC entry 3383 (class 2606 OID 20549)
-- Name: tbl_galeri tbl_galeri_id_admin_uploader_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_galeri
    ADD CONSTRAINT tbl_galeri_id_admin_uploader_fkey FOREIGN KEY (id_admin_uploader) REFERENCES public.tbl_admin(id_admin) ON DELETE SET NULL;


--
-- TOC entry 3384 (class 2606 OID 20554)
-- Name: tbl_halaman_statis tbl_halaman_statis_id_admin_terakhir_edit_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_halaman_statis
    ADD CONSTRAINT tbl_halaman_statis_id_admin_terakhir_edit_fkey FOREIGN KEY (id_admin_terakhir_edit) REFERENCES public.tbl_admin(id_admin) ON DELETE SET NULL;


--
-- TOC entry 3385 (class 2606 OID 20559)
-- Name: tbl_konsultasi tbl_konsultasi_id_admin_penjawab_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_konsultasi
    ADD CONSTRAINT tbl_konsultasi_id_admin_penjawab_fkey FOREIGN KEY (id_admin_penjawab) REFERENCES public.tbl_admin(id_admin) ON DELETE SET NULL;


--
-- TOC entry 3387 (class 2606 OID 20564)
-- Name: tbl_penelitian_anggota tbl_penelitian_anggota_id_penelitian_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_penelitian_anggota
    ADD CONSTRAINT tbl_penelitian_anggota_id_penelitian_fkey FOREIGN KEY (id_penelitian) REFERENCES public.tbl_penelitian(id_penelitian) ON DELETE CASCADE;


--
-- TOC entry 3388 (class 2606 OID 20569)
-- Name: tbl_penelitian_anggota tbl_penelitian_anggota_id_pengelola_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_penelitian_anggota
    ADD CONSTRAINT tbl_penelitian_anggota_id_pengelola_fkey FOREIGN KEY (id_pengelola) REFERENCES public.tbl_pengelola(id_pengelola) ON DELETE CASCADE;


--
-- TOC entry 3386 (class 2606 OID 20574)
-- Name: tbl_penelitian tbl_penelitian_id_admin_pencatat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_penelitian
    ADD CONSTRAINT tbl_penelitian_id_admin_pencatat_fkey FOREIGN KEY (id_admin_pencatat) REFERENCES public.tbl_admin(id_admin) ON DELETE SET NULL;


--
-- TOC entry 3390 (class 2606 OID 20579)
-- Name: tbl_pengabdian_anggota tbl_pengabdian_anggota_id_pengabdian_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengabdian_anggota
    ADD CONSTRAINT tbl_pengabdian_anggota_id_pengabdian_fkey FOREIGN KEY (id_pengabdian) REFERENCES public.tbl_pengabdian(id_pengabdian) ON DELETE CASCADE;


--
-- TOC entry 3391 (class 2606 OID 20584)
-- Name: tbl_pengabdian_anggota tbl_pengabdian_anggota_id_pengelola_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengabdian_anggota
    ADD CONSTRAINT tbl_pengabdian_anggota_id_pengelola_fkey FOREIGN KEY (id_pengelola) REFERENCES public.tbl_pengelola(id_pengelola) ON DELETE CASCADE;


--
-- TOC entry 3389 (class 2606 OID 20589)
-- Name: tbl_pengabdian tbl_pengabdian_id_admin_pencatat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengabdian
    ADD CONSTRAINT tbl_pengabdian_id_admin_pencatat_fkey FOREIGN KEY (id_admin_pencatat) REFERENCES public.tbl_admin(id_admin) ON DELETE SET NULL;


--
-- TOC entry 3393 (class 2606 OID 20594)
-- Name: tbl_pengelola tbl_pengelola_id_admin_pencatat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_pengelola
    ADD CONSTRAINT tbl_pengelola_id_admin_pencatat_fkey FOREIGN KEY (id_admin_pencatat) REFERENCES public.tbl_admin(id_admin) ON DELETE SET NULL;


--
-- TOC entry 3396 (class 2606 OID 20599)
-- Name: tbl_sarana_prasarana tbl_sarana_prasarana_id_admin_pencatat_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tbl_sarana_prasarana
    ADD CONSTRAINT tbl_sarana_prasarana_id_admin_pencatat_fkey FOREIGN KEY (id_admin_pencatat) REFERENCES public.tbl_admin(id_admin) ON DELETE SET NULL;


-- Completed on 2025-12-15 01:13:36

--
-- PostgreSQL database dump complete
--

\unrestrict HAx6DH3dNX9AcK1Q41wm7SKlKsUwH9ddwfSlTZjh1u6GP7s9vbRIaLYiXosYT8t

