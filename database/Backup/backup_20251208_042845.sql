--
-- PostgreSQL database dump
--

-- Dumped from database version 17.5
-- Dumped by pg_dump version 17.5

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: evaluaciones; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.evaluaciones (
    id bigint NOT NULL,
    medida_id bigint NOT NULL,
    oms_ref_id bigint NOT NULL,
    frisancho_ref_id bigint NOT NULL,
    imc numeric(5,2) NOT NULL,
    peso_ideal numeric(6,2),
    dif_peso numeric(6,2),
    cmb_mm numeric(6,2),
    amb_mm2 numeric(10,2),
    agb_mm2 numeric(10,2),
    z_imc numeric(4,2),
    dx_z_imc character varying(100),
    z_talla numeric(4,2),
    dx_z_talla character varying(100),
    z_pb numeric(4,2),
    dx_z_pb character varying(100),
    z_pct numeric(4,2),
    dx_z_pct character varying(100),
    z_cmb numeric(4,2),
    dx_z_cmb character varying(100),
    z_amb numeric(4,2),
    dx_z_amb character varying(100),
    z_agb numeric(4,2),
    dx_z_agb character varying(100),
    registrado_por bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.evaluaciones OWNER TO postgres;

--
-- Name: evaluaciones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.evaluaciones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.evaluaciones_id_seq OWNER TO postgres;

--
-- Name: evaluaciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.evaluaciones_id_seq OWNED BY public.evaluaciones.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: frisancho_ref; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.frisancho_ref (
    id bigint NOT NULL,
    genero character varying(255) NOT NULL,
    edad_anios smallint NOT NULL,
    pb_menos_sd numeric(6,2) NOT NULL,
    pb_dato numeric(6,2) NOT NULL,
    pb_mas_sd numeric(6,2) NOT NULL,
    pct_menos_sd numeric(6,2) NOT NULL,
    pct_dato numeric(6,2) NOT NULL,
    pct_mas_sd numeric(6,2) NOT NULL,
    cmb_menos_sd numeric(6,2) NOT NULL,
    cmb_dato numeric(6,2) NOT NULL,
    cmb_mas_sd numeric(6,2) NOT NULL,
    amb_menos_sd numeric(10,2) NOT NULL,
    amb_dato numeric(10,2) NOT NULL,
    amb_mas_sd numeric(10,2) NOT NULL,
    agb_menos_sd numeric(10,2) NOT NULL,
    agb_dato numeric(10,2) NOT NULL,
    agb_mas_sd numeric(10,2) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT frisancho_ref_genero_check CHECK (((genero)::text = ANY ((ARRAY['masculino'::character varying, 'femenino'::character varying])::text[])))
);


ALTER TABLE public.frisancho_ref OWNER TO postgres;

--
-- Name: frisancho_ref_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.frisancho_ref_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.frisancho_ref_id_seq OWNER TO postgres;

--
-- Name: frisancho_ref_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.frisancho_ref_id_seq OWNED BY public.frisancho_ref.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: medidas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.medidas (
    id bigint NOT NULL,
    paciente_id bigint NOT NULL,
    fecha date NOT NULL,
    edad_meses smallint NOT NULL,
    peso_kg numeric(6,2) NOT NULL,
    talla_cm numeric(5,2) NOT NULL,
    pb_mm numeric(6,2),
    pct_mm numeric(6,2),
    estado character varying(10) DEFAULT 'Activo'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT medidas_estado_chk CHECK (((estado)::text = ANY ((ARRAY['Activo'::character varying, 'Inactivo'::character varying])::text[])))
);


ALTER TABLE public.medidas OWNER TO postgres;

--
-- Name: medidas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.medidas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.medidas_id_seq OWNER TO postgres;

--
-- Name: medidas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.medidas_id_seq OWNED BY public.medidas.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: model_has_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.model_has_permissions (
    permission_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_permissions OWNER TO postgres;

--
-- Name: model_has_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.model_has_roles (
    role_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_roles OWNER TO postgres;

--
-- Name: molecula_calorica; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.molecula_calorica (
    id bigint NOT NULL,
    paciente_id bigint NOT NULL,
    medida_id bigint,
    requerimiento_id bigint,
    peso_kg numeric(6,2) NOT NULL,
    talla_cm numeric(5,2) NOT NULL,
    kilocalorias_totales numeric(8,2) NOT NULL,
    proteinas_g_kg numeric(5,2),
    grasas_g_kg numeric(5,2),
    carbohidratos_g_kg numeric(5,2),
    kilocalorias_proteinas numeric(8,2),
    kilocalorias_grasas numeric(8,2),
    kilocalorias_carbohidratos numeric(8,2),
    porcentaje_proteinas numeric(5,2),
    porcentaje_grasas numeric(5,2),
    porcentaje_carbohidratos numeric(5,2),
    registrado_por bigint NOT NULL,
    estado character varying(255) DEFAULT 'activo'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT molecula_calorica_estado_check CHECK (((estado)::text = ANY ((ARRAY['activo'::character varying, 'inactivo'::character varying])::text[])))
);


ALTER TABLE public.molecula_calorica OWNER TO postgres;

--
-- Name: molecula_calorica_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.molecula_calorica_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.molecula_calorica_id_seq OWNER TO postgres;

--
-- Name: molecula_calorica_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.molecula_calorica_id_seq OWNED BY public.molecula_calorica.id;


--
-- Name: oms_ref; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.oms_ref (
    id bigint NOT NULL,
    genero character varying(255) NOT NULL,
    edad_meses smallint NOT NULL,
    imc_menos_sd numeric(5,2) NOT NULL,
    imc_mediana numeric(5,2) NOT NULL,
    imc_mas_sd numeric(5,2) NOT NULL,
    talla_menos_sd_cm numeric(5,2) NOT NULL,
    talla_mediana_cm numeric(5,2) NOT NULL,
    talla_mas_sd_cm numeric(5,2) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT oms_ref_genero_check CHECK (((genero)::text = ANY ((ARRAY['masculino'::character varying, 'femenino'::character varying])::text[])))
);


ALTER TABLE public.oms_ref OWNER TO postgres;

--
-- Name: oms_ref_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.oms_ref_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.oms_ref_id_seq OWNER TO postgres;

--
-- Name: oms_ref_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.oms_ref_id_seq OWNED BY public.oms_ref.id;


--
-- Name: pacientes; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pacientes (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    apellido_paterno character varying(255) NOT NULL,
    apellido_materno character varying(255) NOT NULL,
    "CI" character varying(255) NOT NULL,
    fecha_nacimiento date NOT NULL,
    genero character varying(255) NOT NULL,
    estado character varying(255) DEFAULT 'activo'::character varying NOT NULL,
    tutor_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT pacientes_estado_check CHECK (((estado)::text = ANY ((ARRAY['activo'::character varying, 'inactivo'::character varying])::text[]))),
    CONSTRAINT pacientes_genero_check CHECK (((genero)::text = ANY ((ARRAY['masculino'::character varying, 'femenino'::character varying])::text[])))
);


ALTER TABLE public.pacientes OWNER TO postgres;

--
-- Name: pacientes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pacientes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pacientes_id_seq OWNER TO postgres;

--
-- Name: pacientes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pacientes_id_seq OWNED BY public.pacientes.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.permissions_id_seq OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- Name: requerimientos_nutricionales; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.requerimientos_nutricionales (
    id bigint NOT NULL,
    paciente_id bigint NOT NULL,
    medida_id bigint,
    peso_kg_at numeric(6,2) NOT NULL,
    talla_cm_at numeric(5,2) NOT NULL,
    geb_kcal numeric(8,2) NOT NULL,
    factor_actividad numeric(4,2) NOT NULL,
    factor_lesion numeric(4,2) NOT NULL,
    get_kcal numeric(8,2) NOT NULL,
    kcal_por_kg numeric(6,2) NOT NULL,
    estado character varying(255) DEFAULT 'activo'::character varying NOT NULL,
    registrado_por bigint NOT NULL,
    calculado_en timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT requerimientos_estado_chk CHECK (((estado)::text = ANY ((ARRAY['activo'::character varying, 'inactivo'::character varying])::text[]))),
    CONSTRAINT requerimientos_nutricionales_estado_check CHECK (((estado)::text = ANY ((ARRAY['activo'::character varying, 'inactivo'::character varying])::text[])))
);


ALTER TABLE public.requerimientos_nutricionales OWNER TO postgres;

--
-- Name: requerimientos_nutricionales_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.requerimientos_nutricionales_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.requerimientos_nutricionales_id_seq OWNER TO postgres;

--
-- Name: requerimientos_nutricionales_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.requerimientos_nutricionales_id_seq OWNED BY public.requerimientos_nutricionales.id;


--
-- Name: role_has_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.role_has_permissions (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);


ALTER TABLE public.role_has_permissions OWNER TO postgres;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: seguimientos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seguimientos (
    id bigint NOT NULL,
    paciente_id bigint NOT NULL,
    peso numeric(5,2) NOT NULL,
    talla numeric(5,2) NOT NULL,
    fecha_seguimiento date NOT NULL,
    estado character varying(255) DEFAULT 'activo'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT seguimientos_estado_check CHECK (((estado)::text = ANY ((ARRAY['activo'::character varying, 'inactivo'::character varying])::text[])))
);


ALTER TABLE public.seguimientos OWNER TO postgres;

--
-- Name: seguimientos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.seguimientos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.seguimientos_id_seq OWNER TO postgres;

--
-- Name: seguimientos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.seguimientos_id_seq OWNED BY public.seguimientos.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: tutores; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tutores (
    id bigint NOT NULL,
    nombre character varying(100) NOT NULL,
    apellido_paterno character varying(100) NOT NULL,
    apellido_materno character varying(100),
    "CI" character varying(20) NOT NULL,
    telefono character varying(15),
    direccion character varying(255),
    parentesco character varying(50) NOT NULL,
    estado character varying(255) DEFAULT 'activo'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tutores_estado_check CHECK (((estado)::text = ANY ((ARRAY['activo'::character varying, 'inactivo'::character varying])::text[])))
);


ALTER TABLE public.tutores OWNER TO postgres;

--
-- Name: tutores_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tutores_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tutores_id_seq OWNER TO postgres;

--
-- Name: tutores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tutores_id_seq OWNED BY public.tutores.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    nombre character varying(100) NOT NULL,
    apellido_paterno character varying(100) NOT NULL,
    apellido_materno character varying(100),
    ci character varying(20) NOT NULL,
    email character varying(100) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    fecha_nacimiento date,
    direccion character varying(255),
    telefono character varying(15),
    genero character varying(10),
    estado character varying(255) DEFAULT 'activo'::character varying NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT users_estado_check CHECK (((estado)::text = ANY ((ARRAY['activo'::character varying, 'inactivo'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: evaluaciones id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluaciones ALTER COLUMN id SET DEFAULT nextval('public.evaluaciones_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: frisancho_ref id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.frisancho_ref ALTER COLUMN id SET DEFAULT nextval('public.frisancho_ref_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: medidas id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.medidas ALTER COLUMN id SET DEFAULT nextval('public.medidas_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: molecula_calorica id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.molecula_calorica ALTER COLUMN id SET DEFAULT nextval('public.molecula_calorica_id_seq'::regclass);


--
-- Name: oms_ref id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oms_ref ALTER COLUMN id SET DEFAULT nextval('public.oms_ref_id_seq'::regclass);


--
-- Name: pacientes id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pacientes ALTER COLUMN id SET DEFAULT nextval('public.pacientes_id_seq'::regclass);


--
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- Name: requerimientos_nutricionales id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.requerimientos_nutricionales ALTER COLUMN id SET DEFAULT nextval('public.requerimientos_nutricionales_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: seguimientos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seguimientos ALTER COLUMN id SET DEFAULT nextval('public.seguimientos_id_seq'::regclass);


--
-- Name: tutores id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tutores ALTER COLUMN id SET DEFAULT nextval('public.tutores_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
laravel-cache-lv:v3.21.1:file:4dc1ddfd-laravel.log:ecf8427e:chunk:0	a:270:{i:1759122407;a:1:{s:5:"ERROR";a:1:{i:0;i:0;}}i:1759122427;a:1:{s:5:"ERROR";a:1:{i:1;i:20560;}}i:1759123410;a:1:{s:5:"ERROR";a:1:{i:2;i:41120;}}i:1759123519;a:1:{s:5:"ERROR";a:1:{i:3;i:52078;}}i:1759123526;a:1:{s:5:"ERROR";a:1:{i:4;i:63036;}}i:1759123530;a:1:{s:5:"ERROR";a:1:{i:5;i:73994;}}i:1759123548;a:1:{s:5:"ERROR";a:1:{i:6;i:84952;}}i:1759123567;a:1:{s:5:"ERROR";a:1:{i:7;i:95910;}}i:1759123616;a:1:{s:5:"ERROR";a:1:{i:8;i:106868;}}i:1759124038;a:1:{s:5:"ERROR";a:1:{i:9;i:121391;}}i:1759124323;a:1:{s:5:"ERROR";a:1:{i:10;i:135629;}}i:1759124376;a:1:{s:5:"ERROR";a:1:{i:11;i:206235;}}i:1759126600;a:1:{s:5:"ERROR";a:1:{i:12;i:276813;}}i:1759126674;a:1:{s:5:"ERROR";a:1:{i:13;i:347419;}}i:1759126792;a:1:{s:5:"ERROR";a:1:{i:14;i:418025;}}i:1759126796;a:1:{s:5:"ERROR";a:1:{i:15;i:446117;}}i:1759126955;a:1:{s:5:"ERROR";a:1:{i:16;i:451191;}}i:1759126959;a:1:{s:5:"ERROR";a:1:{i:17;i:479596;}}i:1759126999;a:1:{s:5:"ERROR";a:1:{i:18;i:484983;}}i:1759127001;a:1:{s:5:"ERROR";a:1:{i:19;i:513388;}}i:1759127298;a:1:{s:5:"ERROR";a:1:{i:20;i:518775;}}i:1759127302;a:1:{s:5:"ERROR";a:1:{i:21;i:547180;}}i:1759127399;a:1:{s:5:"ERROR";a:1:{i:22;i:552567;}}i:1759127402;a:1:{s:5:"ERROR";a:1:{i:23;i:580972;}}i:1759127410;a:1:{s:5:"ERROR";a:1:{i:24;i:586359;}}i:1759127413;a:1:{s:5:"ERROR";a:1:{i:25;i:614764;}}i:1759128147;a:1:{s:5:"ERROR";a:1:{i:26;i:620151;}}i:1759218117;a:1:{s:5:"ERROR";a:1:{i:27;i:635834;}}i:1759726974;a:1:{s:5:"ERROR";a:1:{i:28;i:668447;}}i:1759727051;a:1:{s:5:"ERROR";a:1:{i:29;i:739100;}}i:1759727107;a:1:{s:5:"ERROR";a:1:{i:30;i:809753;}}i:1759728737;a:1:{s:5:"ERROR";a:1:{i:31;i:880406;}}i:1759730039;a:1:{s:5:"ERROR";a:1:{i:32;i:900795;}}i:1759730069;a:1:{s:5:"ERROR";a:1:{i:33;i:901247;}}i:1759730165;a:1:{s:5:"ERROR";a:1:{i:34;i:901699;}}i:1759730264;a:1:{s:5:"ERROR";a:1:{i:35;i:902151;}}i:1759731882;a:1:{s:4:"INFO";a:3:{i:36;i:917836;i:37;i:918262;i:38;i:918392;}}i:1759731917;a:2:{s:4:"INFO";a:1:{i:39;i:918523;}s:5:"ERROR";a:1:{i:40;i:918950;}}i:1759731919;a:2:{s:4:"INFO";a:1:{i:41;i:934392;}s:5:"ERROR";a:1:{i:42;i:934819;}}i:1759734542;a:1:{s:5:"ERROR";a:1:{i:43;i:950261;}}i:1759906100;a:1:{s:5:"ERROR";a:1:{i:44;i:985026;}}i:1759906107;a:1:{s:5:"ERROR";a:1:{i:45;i:1020595;}}i:1759907206;a:1:{s:5:"ERROR";a:1:{i:46;i:1056164;}}i:1759907270;a:1:{s:5:"ERROR";a:1:{i:47;i:1089428;}}i:1759907615;a:1:{s:5:"ERROR";a:1:{i:48;i:1106446;}}i:1759907671;a:1:{s:5:"ERROR";a:1:{i:49;i:1123464;}}i:1759907700;a:1:{s:5:"ERROR";a:1:{i:50;i:1140416;}}i:1759907800;a:1:{s:5:"ERROR";a:1:{i:51;i:1157434;}}i:1759907861;a:1:{s:5:"ERROR";a:1:{i:52;i:1174452;}}i:1759908066;a:1:{s:5:"ERROR";a:1:{i:53;i:1191470;}}i:1759908080;a:1:{s:5:"ERROR";a:1:{i:54;i:1224736;}}i:1759908089;a:1:{s:5:"ERROR";a:1:{i:55;i:1257990;}}i:1759908116;a:1:{s:5:"ERROR";a:1:{i:56;i:1291244;}}i:1759908693;a:1:{s:5:"ERROR";a:1:{i:57;i:1324503;}}i:1759908731;a:1:{s:5:"ERROR";a:1:{i:58;i:1357757;}}i:1759909092;a:1:{s:5:"ERROR";a:1:{i:59;i:1390388;}}i:1759909104;a:1:{s:5:"ERROR";a:1:{i:60;i:1424733;}}i:1761018945;a:1:{s:5:"ERROR";a:1:{i:61;i:1459078;}}i:1761019048;a:1:{s:5:"ERROR";a:1:{i:62;i:1479368;}}i:1761019096;a:1:{s:5:"ERROR";a:1:{i:63;i:1499658;}}i:1761019187;a:1:{s:5:"ERROR";a:1:{i:64;i:1521472;}}i:1761020759;a:1:{s:5:"ERROR";a:1:{i:65;i:1543286;}}i:1761020830;a:1:{s:5:"ERROR";a:1:{i:66;i:1619560;}}i:1761020868;a:1:{s:5:"ERROR";a:1:{i:67;i:1694581;}}i:1761031432;a:1:{s:5:"ERROR";a:1:{i:68;i:1769602;}}i:1761031472;a:1:{s:5:"ERROR";a:1:{i:69;i:1785360;}}i:1761032054;a:1:{s:5:"ERROR";a:1:{i:70;i:1801118;}}i:1761032444;a:1:{s:5:"ERROR";a:1:{i:71;i:1834077;}}i:1761035335;a:1:{s:5:"ERROR";a:1:{i:72;i:1867289;}}i:1761186540;a:1:{s:5:"ERROR";a:1:{i:73;i:1899916;}}i:1761186553;a:1:{s:5:"ERROR";a:1:{i:74;i:1936048;}}i:1761186690;a:1:{s:5:"ERROR";a:1:{i:75;i:1972180;}}i:1761187547;a:1:{s:5:"ERROR";a:1:{i:76;i:2008265;}}i:1761187627;a:1:{s:5:"ERROR";a:1:{i:77;i:2083305;}}i:1761187673;a:1:{s:5:"ERROR";a:1:{i:78;i:2099065;}}i:1761187864;a:1:{s:5:"ERROR";a:1:{i:79;i:2114825;}}i:1761187881;a:1:{s:5:"ERROR";a:1:{i:80;i:2156072;}}i:1761187938;a:1:{s:5:"ERROR";a:1:{i:81;i:2197319;}}i:1761188890;a:1:{s:5:"ERROR";a:1:{i:82;i:2238566;}}i:1761286708;a:1:{s:5:"ERROR";a:1:{i:83;i:2275931;}}i:1761287451;a:1:{s:5:"ERROR";a:1:{i:84;i:2310189;}}i:1761287593;a:1:{s:5:"ERROR";a:1:{i:85;i:2380848;}}i:1761287728;a:1:{s:5:"ERROR";a:1:{i:86;i:2451507;}}i:1761287778;a:1:{s:5:"ERROR";a:1:{i:87;i:2522166;}}i:1761288608;a:1:{s:5:"ERROR";a:1:{i:88;i:2537930;}}i:1761291778;a:1:{s:5:"ERROR";a:1:{i:89;i:2553711;}}i:1761291807;a:1:{s:5:"ERROR";a:1:{i:90;i:2573201;}}i:1761292959;a:1:{s:5:"ERROR";a:1:{i:91;i:2592687;}}i:1761293016;a:1:{s:5:"ERROR";a:1:{i:92;i:2608456;}}i:1761293020;a:1:{s:5:"ERROR";a:1:{i:93;i:2679155;}}i:1761293187;a:1:{s:5:"ERROR";a:1:{i:94;i:2749854;}}i:1761293251;a:1:{s:5:"ERROR";a:1:{i:95;i:2781135;}}i:1761293265;a:1:{s:5:"ERROR";a:1:{i:96;i:2814419;}}i:1761293272;a:1:{s:5:"ERROR";a:1:{i:97;i:2830183;}}i:1761293298;a:1:{s:5:"ERROR";a:1:{i:98;i:2863467;}}i:1761293321;a:1:{s:5:"ERROR";a:1:{i:99;i:2938537;}}i:1761293446;a:1:{s:5:"ERROR";a:1:{i:100;i:2971821;}}i:1761294139;a:1:{s:5:"ERROR";a:1:{i:101;i:3005102;}}i:1761294430;a:1:{s:5:"ERROR";a:1:{i:102;i:3038332;}}i:1761294459;a:1:{s:5:"ERROR";a:1:{i:103;i:3054096;}}i:1761294843;a:1:{s:5:"ERROR";a:1:{i:104;i:3069860;}}i:1761294974;a:1:{s:5:"ERROR";a:1:{i:105;i:3103165;}}i:1761295116;a:1:{s:5:"ERROR";a:1:{i:106;i:3136467;}}i:1761295208;a:1:{s:5:"ERROR";a:1:{i:107;i:3169772;}}i:1761295427;a:1:{s:4:"INFO";a:1:{i:108;i:3185580;}}i:1761295649;a:1:{s:5:"ERROR";a:1:{i:109;i:3185706;}}i:1761296151;a:1:{s:5:"ERROR";a:1:{i:110;i:3223589;}}i:1761297004;a:1:{s:5:"ERROR";a:1:{i:111;i:3239353;}}i:1761297244;a:1:{s:5:"ERROR";a:1:{i:112;i:3255117;}}i:1761297293;a:1:{s:5:"ERROR";a:1:{i:113;i:3270881;}}i:1761298929;a:1:{s:5:"ERROR";a:1:{i:114;i:3304152;}}i:1761300535;a:1:{s:5:"ERROR";a:1:{i:115;i:3326014;}}i:1761300564;a:1:{s:5:"ERROR";a:1:{i:116;i:3401054;}}i:1761300681;a:1:{s:4:"INFO";a:1:{i:117;i:3476094;}}i:1761300729;a:1:{s:5:"ERROR";a:1:{i:118;i:3476220;}}i:1761300934;a:1:{s:5:"ERROR";a:1:{i:119;i:3492094;}}i:1761300984;a:1:{s:5:"ERROR";a:1:{i:120;i:3508883;}}i:1761301353;a:1:{s:5:"ERROR";a:1:{i:121;i:3525672;}}i:1761301359;a:1:{s:5:"ERROR";a:1:{i:122;i:3560085;}}i:1761301711;a:1:{s:5:"ERROR";a:1:{i:123;i:3594498;}}i:1761302042;a:1:{s:5:"ERROR";a:1:{i:124;i:3628929;}}i:1761303776;a:1:{s:4:"INFO";a:6:{i:125;i:3643853;i:126;i:3643961;i:127;i:3644016;i:128;i:3644076;i:129;i:3644137;i:130;i:3644193;}}i:1761303782;a:1:{s:4:"INFO";a:6:{i:131;i:3644256;i:132;i:3644364;i:133;i:3644419;i:134;i:3644479;i:135;i:3644540;i:136;i:3644596;}}i:1761303785;a:1:{s:4:"INFO";a:6:{i:137;i:3644659;i:138;i:3644767;i:139;i:3644822;i:140;i:3644882;i:141;i:3644943;i:142;i:3644999;}}i:1761303841;a:1:{s:4:"INFO";a:6:{i:143;i:3645062;i:144;i:3645170;i:145;i:3645225;i:146;i:3645285;i:147;i:3645346;i:148;i:3645402;}}i:1761303843;a:1:{s:4:"INFO";a:6:{i:149;i:3645465;i:150;i:3645573;i:151;i:3645628;i:152;i:3645688;i:153;i:3645749;i:154;i:3645805;}}i:1761303846;a:1:{s:4:"INFO";a:6:{i:155;i:3645868;i:156;i:3645976;i:157;i:3646031;i:158;i:3646091;i:159;i:3646152;i:160;i:3646208;}}i:1761303878;a:1:{s:5:"ERROR";a:1:{i:161;i:3646271;}}i:1761340331;a:1:{s:4:"INFO";a:1:{i:162;i:3652369;}}i:1761340354;a:1:{s:4:"INFO";a:2:{i:163;i:3652495;i:164;i:3652586;}}i:1761340361;a:1:{s:4:"INFO";a:6:{i:165;i:3652641;i:166;i:3652749;i:167;i:3652804;i:168;i:3652864;i:169;i:3652925;i:170;i:3652981;}}i:1761340428;a:1:{s:4:"INFO";a:6:{i:171;i:3653044;i:172;i:3653152;i:173;i:3653207;i:174;i:3653267;i:175;i:3653328;i:176;i:3653384;}}i:1761340437;a:1:{s:4:"INFO";a:6:{i:177;i:3653447;i:178;i:3653555;i:179;i:3653610;i:180;i:3653670;i:181;i:3653731;i:182;i:3653787;}}i:1761352038;a:1:{s:4:"INFO";a:1:{i:183;i:3653850;}}i:1761352051;a:1:{s:4:"INFO";a:2:{i:184;i:3653976;i:185;i:3654067;}}i:1761352059;a:1:{s:4:"INFO";a:6:{i:186;i:3654122;i:187;i:3654230;i:188;i:3654285;i:189;i:3654345;i:190;i:3654406;i:191;i:3654462;}}i:1761352103;a:1:{s:4:"INFO";a:6:{i:192;i:3654525;i:193;i:3654633;i:194;i:3654688;i:195;i:3654748;i:196;i:3654809;i:197;i:3654865;}}i:1761352644;a:1:{s:4:"INFO";a:1:{i:198;i:3654928;}}i:1761352661;a:1:{s:4:"INFO";a:2:{i:199;i:3655054;i:200;i:3655145;}}i:1761352669;a:1:{s:4:"INFO";a:6:{i:201;i:3655200;i:202;i:3655308;i:203;i:3655363;i:204;i:3655423;i:205;i:3655484;i:206;i:3655540;}}i:1761352705;a:1:{s:4:"INFO";a:6:{i:207;i:3655603;i:208;i:3655711;i:209;i:3655766;i:210;i:3655826;i:211;i:3655887;i:212;i:3655943;}}i:1761353314;a:1:{s:4:"INFO";a:6:{i:213;i:3656006;i:214;i:3656114;i:215;i:3656169;i:216;i:3656229;i:217;i:3656290;i:218;i:3656346;}}i:1761354211;a:1:{s:4:"INFO";a:1:{i:219;i:3656409;}}i:1761354223;a:1:{s:4:"INFO";a:2:{i:220;i:3656535;i:221;i:3656626;}}i:1761354233;a:1:{s:4:"INFO";a:6:{i:222;i:3656681;i:223;i:3656789;i:224;i:3656844;i:225;i:3656904;i:226;i:3656965;i:227;i:3657021;}}i:1761354241;a:1:{s:4:"INFO";a:6:{i:228;i:3657083;i:229;i:3657191;i:230;i:3657246;i:231;i:3657306;i:232;i:3657367;i:233;i:3657423;}}i:1761354247;a:1:{s:4:"INFO";a:6:{i:234;i:3657486;i:235;i:3657594;i:236;i:3657649;i:237;i:3657709;i:238;i:3657770;i:239;i:3657826;}}i:1761354249;a:1:{s:4:"INFO";a:2:{i:240;i:3657889;i:241;i:3657980;}}i:1761354256;a:1:{s:4:"INFO";a:6:{i:242;i:3658035;i:243;i:3658143;i:244;i:3658198;i:245;i:3658258;i:246;i:3658319;i:247;i:3658375;}}i:1761356347;a:1:{s:4:"INFO";a:1:{i:248;i:3658437;}}i:1761356366;a:1:{s:4:"INFO";a:2:{i:249;i:3658563;i:250;i:3658654;}}i:1761356371;a:1:{s:4:"INFO";a:6:{i:251;i:3658709;i:252;i:3658817;i:253;i:3658872;i:254;i:3658932;i:255;i:3658993;i:256;i:3659049;}}i:1762226324;a:1:{s:4:"INFO";a:2:{i:257;i:3659112;i:258;i:3659203;}}i:1762227027;a:1:{s:4:"INFO";a:2:{i:259;i:3659258;i:260;i:3659349;}}i:1762231262;a:1:{s:5:"ERROR";a:1:{i:261;i:3659404;}}i:1762231685;a:1:{s:5:"ERROR";a:1:{i:262;i:3676804;}}i:1762231898;a:1:{s:5:"ERROR";a:1:{i:263;i:3694204;}}i:1762232579;a:1:{s:5:"ERROR";a:1:{i:264;i:3729520;}}i:1762232609;a:1:{s:5:"ERROR";a:1:{i:265;i:3762796;}}i:1762232683;a:1:{s:5:"ERROR";a:1:{i:266;i:3778604;}}i:1762233423;a:1:{s:5:"ERROR";a:1:{i:267;i:3811880;}}i:1762233447;a:1:{s:5:"ERROR";a:1:{i:268;i:3845156;}}i:1762234559;a:1:{s:5:"ERROR";a:1:{i:269;i:3878432;}}i:1762234699;a:1:{s:5:"ERROR";a:1:{i:270;i:3911705;}}i:1762234718;a:1:{s:5:"ERROR";a:1:{i:271;i:3944978;}}i:1762236686;a:1:{s:5:"ERROR";a:1:{i:272;i:3977517;}}i:1762237259;a:1:{s:5:"ERROR";a:1:{i:273;i:4008639;}}i:1762237345;a:1:{s:5:"ERROR";a:1:{i:274;i:4039761;}}i:1762237477;a:1:{s:5:"ERROR";a:1:{i:275;i:4070883;}}i:1762237480;a:1:{s:5:"ERROR";a:1:{i:276;i:4102005;}}i:1762237529;a:1:{s:5:"ERROR";a:1:{i:277;i:4133127;}}i:1762237632;a:1:{s:5:"ERROR";a:1:{i:278;i:4164249;}}i:1762237999;a:1:{s:5:"ERROR";a:1:{i:279;i:4195371;}}i:1762238074;a:1:{s:5:"ERROR";a:1:{i:280;i:4226493;}}i:1762238163;a:1:{s:5:"ERROR";a:1:{i:281;i:4232591;}}i:1762238183;a:1:{s:5:"ERROR";a:1:{i:282;i:4263713;}}i:1762238214;a:1:{s:5:"ERROR";a:1:{i:283;i:4294835;}}i:1762238304;a:1:{s:5:"ERROR";a:1:{i:284;i:4300933;}}i:1762238345;a:1:{s:5:"ERROR";a:1:{i:285;i:4307031;}}i:1762238434;a:1:{s:5:"ERROR";a:1:{i:286;i:4313129;}}i:1762238566;a:1:{s:5:"ERROR";a:1:{i:287;i:4344251;}}i:1762238578;a:1:{s:5:"ERROR";a:1:{i:288;i:4350349;}}i:1762238650;a:1:{s:5:"ERROR";a:1:{i:289;i:4356447;}}i:1762238700;a:1:{s:5:"ERROR";a:1:{i:290;i:4362545;}}i:1762238715;a:1:{s:5:"ERROR";a:1:{i:291;i:4368643;}}i:1762238724;a:1:{s:5:"ERROR";a:1:{i:292;i:4374741;}}i:1762238770;a:1:{s:5:"ERROR";a:1:{i:293;i:4380839;}}i:1762238901;a:1:{s:5:"ERROR";a:1:{i:294;i:4411961;}}i:1762238947;a:1:{s:5:"ERROR";a:1:{i:295;i:4443083;}}i:1762239095;a:1:{s:5:"ERROR";a:1:{i:296;i:4474205;}}i:1762239175;a:1:{s:5:"ERROR";a:1:{i:297;i:4505289;}}i:1762239176;a:1:{s:5:"ERROR";a:1:{i:298;i:4536411;}}i:1762239249;a:1:{s:5:"ERROR";a:1:{i:299;i:4567533;}}i:1762239393;a:1:{s:5:"ERROR";a:1:{i:300;i:4598655;}}i:1762239398;a:1:{s:5:"ERROR";a:1:{i:301;i:4629777;}}i:1762239404;a:1:{s:5:"ERROR";a:1:{i:302;i:4660899;}}i:1762239410;a:1:{s:5:"ERROR";a:1:{i:303;i:4692021;}}i:1762239541;a:1:{s:5:"ERROR";a:1:{i:304;i:4723143;}}i:1762239593;a:1:{s:5:"ERROR";a:1:{i:305;i:4754265;}}i:1762240035;a:1:{s:5:"ERROR";a:1:{i:306;i:4785387;}}i:1762240058;a:1:{s:5:"ERROR";a:1:{i:307;i:4816509;}}i:1762240253;a:1:{s:5:"ERROR";a:1:{i:308;i:4847631;}}i:1762240275;a:1:{s:5:"ERROR";a:1:{i:309;i:4878721;}}i:1762826507;a:1:{s:5:"ERROR";a:1:{i:310;i:4884819;}}i:1762826517;a:1:{s:5:"ERROR";a:1:{i:311;i:4899454;}}i:1762826658;a:1:{s:5:"ERROR";a:1:{i:312;i:4914089;}}i:1762826717;a:1:{s:5:"ERROR";a:1:{i:313;i:4984748;}}i:1762826838;a:1:{s:5:"ERROR";a:1:{i:314;i:5015836;}}i:1762828380;a:1:{s:5:"ERROR";a:1:{i:315;i:5046921;}}i:1762828512;a:1:{s:5:"ERROR";a:1:{i:316;i:5117575;}}i:1762828560;a:1:{s:5:"ERROR";a:1:{i:317;i:5148663;}}i:1762828637;a:1:{s:5:"ERROR";a:1:{i:318;i:5179751;}}i:1762828828;a:1:{s:5:"ERROR";a:1:{i:319;i:5210803;}}i:1762829333;a:1:{s:5:"ERROR";a:1:{i:320;i:5241924;}}i:1762829337;a:1:{s:5:"ERROR";a:1:{i:321;i:5312581;}}i:1762829454;a:1:{s:5:"ERROR";a:1:{i:322;i:5383238;}}i:1762829485;a:1:{s:5:"ERROR";a:1:{i:323;i:5414360;}}i:1762829492;a:1:{s:5:"ERROR";a:1:{i:324;i:5445482;}}i:1762829550;a:1:{s:5:"ERROR";a:1:{i:325;i:5476604;}}i:1762829671;a:1:{s:5:"ERROR";a:1:{i:326;i:5507726;}}i:1762829843;a:1:{s:5:"ERROR";a:1:{i:327;i:5538848;}}i:1762829849;a:1:{s:5:"ERROR";a:1:{i:328;i:5569970;}}i:1762829922;a:1:{s:5:"ERROR";a:1:{i:329;i:5601092;}}i:1762830030;a:1:{s:5:"ERROR";a:1:{i:330;i:5632180;}}i:1762830077;a:1:{s:5:"ERROR";a:1:{i:331;i:5638278;}}i:1762830661;a:1:{s:5:"ERROR";a:1:{i:332;i:5669366;}}i:1762830677;a:1:{s:5:"ERROR";a:1:{i:333;i:5700454;}}i:1762831725;a:1:{s:5:"ERROR";a:1:{i:334;i:5731542;}}i:1762831825;a:1:{s:5:"ERROR";a:1:{i:335;i:5806567;}}i:1762832173;a:1:{s:5:"ERROR";a:1:{i:336;i:5881592;}}i:1762832896;a:1:{s:4:"INFO";a:1:{i:337;i:5897400;}}i:1762833995;a:1:{s:5:"ERROR";a:1:{i:338;i:5897526;}}i:1762837043;a:1:{s:5:"ERROR";a:1:{i:339;i:5930716;}}i:1762839326;a:1:{s:5:"ERROR";a:1:{i:340;i:5964232;}}i:1762839710;a:1:{s:5:"ERROR";a:1:{i:341;i:5982166;}}i:1762901923;a:1:{s:4:"INFO";a:1:{i:342;i:6015332;}}i:1762918705;a:1:{s:4:"INFO";a:1:{i:343;i:6015458;}}i:1762918795;a:1:{s:4:"INFO";a:1:{i:344;i:6015584;}}i:1762937424;a:1:{s:4:"INFO";a:1:{i:345;i:6015711;}}i:1762938056;a:1:{s:4:"INFO";a:1:{i:346;i:6015838;}}i:1762938855;a:1:{s:4:"INFO";a:1:{i:347;i:6015965;}}i:1763011971;a:1:{s:4:"INFO";a:1:{i:348;i:6016092;}}i:1763012587;a:1:{s:4:"INFO";a:1:{i:349;i:6016219;}}i:1763013439;a:1:{s:4:"INFO";a:1:{i:350;i:6016346;}}i:1763014393;a:1:{s:4:"INFO";a:1:{i:351;i:6016473;}}i:1763016586;a:1:{s:4:"INFO";a:1:{i:352;i:6016600;}}i:1763531731;a:1:{s:5:"ERROR";a:1:{i:353;i:6016727;}}i:1763531806;a:1:{s:5:"ERROR";a:1:{i:354;i:6031576;}}i:1763531819;a:1:{s:5:"ERROR";a:1:{i:355;i:6046425;}}i:1763532570;a:1:{s:5:"ERROR";a:1:{i:356;i:6061274;}}i:1763618284;a:1:{s:4:"INFO";a:1:{i:357;i:6094477;}}i:1763760967;a:1:{s:4:"INFO";a:1:{i:358;i:6094604;}}i:1764575993;a:1:{s:5:"ERROR";a:1:{i:359;i:6094731;}}i:1764576014;a:1:{s:5:"ERROR";a:1:{i:360;i:6109201;}}i:1764576124;a:1:{s:5:"ERROR";a:1:{i:361;i:6123671;}}i:1764576256;a:1:{s:5:"ERROR";a:1:{i:362;i:6160052;}}i:1764576547;a:1:{s:5:"ERROR";a:1:{i:363;i:6192153;}}i:1764576559;a:1:{s:5:"ERROR";a:1:{i:364;i:6226148;}}i:1764577997;a:1:{s:5:"ERROR";a:1:{i:365;i:6260143;}}i:1764650326;a:1:{s:5:"ERROR";a:1:{i:366;i:6291157;}}i:1764650400;a:1:{s:5:"ERROR";a:1:{i:367;i:6322267;}}i:1764650522;a:1:{s:5:"ERROR";a:1:{i:368;i:6355773;}}i:1764650666;a:1:{s:5:"ERROR";a:1:{i:369;i:6386883;}}i:1764650745;a:1:{s:5:"ERROR";a:1:{i:370;i:6418017;}}i:1764654985;a:1:{s:5:"ERROR";a:1:{i:371;i:6449182;}}i:1764656662;a:1:{s:5:"ERROR";a:1:{i:372;i:6466361;}}i:1764656684;a:1:{s:5:"ERROR";a:1:{i:373;i:6483540;}}i:1765087493;a:1:{s:5:"ERROR";a:1:{i:374;i:6500719;}}i:1765087599;a:1:{s:5:"ERROR";a:1:{i:375;i:6509119;}}i:1765087605;a:1:{s:5:"ERROR";a:1:{i:376;i:6523797;}}}	1765692626
laravel-cache-lv:v3.21.1:file:4dc1ddfd-laravel.log:ecf8427e:metadata	a:9:{s:5:"query";N;s:10:"identifier";s:8:"ecf8427e";s:26:"last_scanned_file_position";i:6538475;s:18:"last_scanned_index";i:377;s:24:"next_log_index_to_create";i:377;s:14:"max_chunk_size";i:50000;s:19:"current_chunk_index";i:0;s:17:"chunk_definitions";a:0:{}s:24:"current_chunk_definition";a:5:{s:5:"index";i:0;s:4:"size";i:377;s:18:"earliest_timestamp";i:1759122407;s:16:"latest_timestamp";i:1765087605;s:12:"level_counts";a:2:{s:5:"ERROR";i:221;s:4:"INFO";i:156;}}}	1765692626
laravel-cache-lv:v3.21.1:file:4dc1ddfd-laravel.log:metadata	a:8:{s:4:"type";s:7:"laravel";s:4:"name";s:11:"laravel.log";s:4:"path";s:101:"C:\\Users\\COMPU\\Desktop\\Integrador Materrno Infantil\\Sistema\\materno_infantil\\storage\\logs\\laravel.log";s:4:"size";i:6538475;s:18:"earliest_timestamp";i:1759122407;s:16:"latest_timestamp";i:1765087605;s:26:"last_scanned_file_position";i:6538475;s:15:"related_indices";a:1:{s:8:"ecf8427e";a:2:{s:5:"query";N;s:26:"last_scanned_file_position";i:6538475;}}}	1765692626
laravel-cache-spatie.permission.cache	a:3:{s:5:"alias";a:0:{}s:11:"permissions";a:0:{}s:5:"roles";a:0:{}}	1765174399
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: evaluaciones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.evaluaciones (id, medida_id, oms_ref_id, frisancho_ref_id, imc, peso_ideal, dif_peso, cmb_mm, amb_mm2, agb_mm2, z_imc, dx_z_imc, z_talla, dx_z_talla, z_pb, dx_z_pb, z_pct, dx_z_pct, z_cmb, dx_z_cmb, z_amb, dx_z_amb, z_agb, dx_z_agb, registrado_por, created_at, updated_at) FROM stdin;
1	2	69	6	26.67	37.82	22.18	207.29	3318.45	537.71	4.54		1.24		0.62		-2.50		1.52		2.27		-1.82		1	2025-10-24 10:14:40	2025-10-24 10:14:40
2	3	69	6	26.31	38.33	21.67	201.01	3114.36	741.80	4.38		1.39		0.62		-1.50		1.17		1.64		-0.98		1	2025-10-24 20:28:08	2025-10-24 20:28:08
3	4	69	6	26.67	37.82	22.18	194.73	2916.55	939.61	4.54		1.24		0.62		-0.50		0.82		1.04		-0.17		1	2025-10-25 00:22:12	2025-10-25 00:22:12
4	5	69	6	26.67	37.82	22.18	203.58	3197.25	1096.15	4.54		1.24		1.19		0.00		1.31		1.90		0.29		1	2025-10-25 00:32:43	2025-10-25 00:32:43
5	6	69	6	26.67	37.82	22.18	204.73	3234.33	984.60	4.54		1.24		1.10		-0.50		1.37		2.01		0.01		2	2025-10-25 00:50:24	2025-10-25 00:50:24
6	7	69	6	26.67	37.82	22.18	194.73	2916.55	939.61	4.54		1.24		0.62		-0.50		0.82		1.04		-0.17		3	2025-10-25 00:59:34	2025-10-25 00:59:34
7	8	237	20	30.61	33.48	26.52	194.73	2916.55	939.61	5.29		-0.51		0.72		-1.50		2.47		2.16		-0.67		5	2025-10-25 01:12:20	2025-10-25 01:12:20
8	9	70	6	26.67	37.91	22.09	194.73	2916.55	939.61	4.48		1.17		0.62		-0.50		0.82		1.04		-0.17		6	2025-10-25 01:35:38	2025-10-25 01:35:38
10	11	70	6	21.01	48.13	11.87	206.15	3280.91	646.54	1.90	1	4.02	1	0.71	1	-2.00	1	1.45	1	2.15	1	-1.37	1	1	2025-11-11 05:16:36	2025-11-11 05:16:36
9	10	70	6	23.44	43.14	16.86	206.15	3280.91	646.54	3.01	s	2.67	s	0.71	s	-2.00	s	1.45	sa	2.15	sa	-1.37	sa	1	2025-11-11 05:06:24	2025-11-11 05:48:49
11	12	70	6	19.53	43.14	6.86	203.01	3178.65	748.80	1.22	normal	2.67	normal	0.71	normal	-1.50	normal	1.28	normal	1.84	normal	-0.96	normal	1	2025-11-12 03:34:30	2025-11-12 03:34:30
12	13	129	11	23.44	52.02	7.98	199.87	3077.96	849.49	1.04	Normal	-1.55	Normal	-1.95	Normal	-1.50	Normal	-2.22	Normal	-2.31	Normal	-0.34	Normal	1	2025-11-12 08:49:42	2025-11-12 08:49:42
13	14	70	6	25.51	33.03	16.97	191.15	2806.80	601.55	3.95	Normal	-0.33	Normal	0.00	Normal	-2.00	Normal	0.62	Normal	0.71	Normal	-1.56	Normal	1	2025-11-12 08:59:52	2025-11-12 08:59:52
14	15	70	6	27.34	43.14	26.86	194.87	2920.94	829.50	4.79	Normal	2.67	Normal	0.48	Normal	-1.00	Normal	0.83	Normal	1.05	Normal	-0.63	Normal	1	2025-11-12 09:12:51	2025-11-12 09:12:51
15	16	70	6	25.39	43.14	21.86	221.73	3811.08	1061.08	3.90	Normal	2.67	Normal	1.90	Normal	-0.50	Normal	2.32	Normal	3.77	Normal	0.20	Normal	1	2025-11-13 05:31:50	2025-11-13 05:31:50
16	17	70	6	29.59	28.48	21.52	171.15	2230.35	541.57	5.82	Normal	-1.83	Normal	-1.43	Normal	-2.00	Normal	-0.63	Normal	-0.88	Normal	-1.81	Normal	1	2025-11-13 05:41:56	2025-11-13 05:41:56
17	18	70	6	24.91	45.32	21.68	229.87	4103.57	969.46	3.68	Normal	3.27	Normal	2.14	Normal	-1.00	Normal	2.77	Normal	4.66	Normal	-0.05	Normal	1	2025-11-13 05:56:31	2025-11-13 05:56:31
18	19	129	11	25.26	58.72	14.28	178.01	2420.85	661.33	1.65	Normal	-0.27	Normal	-3.20	Normal	-2.00	Normal	-3.79	Normal	-3.39	Normal	-1.12	Normal	1	2025-11-13 06:11:46	2025-11-13 06:11:46
19	20	70	6	20.80	46.99	11.01	208.01	3342.14	766.30	1.80	Normal	3.72	Normal	0.95	Normal	-1.50	Normal	1.56	Normal	2.34	Normal	-0.88	Normal	1	2025-11-13 06:48:26	2025-11-13 06:48:26
20	21	130	11	27.77	47.71	17.29	233.01	4219.26	853.77	2.45	Normal	-2.49	Normal	-0.45	Normal	-2.00	Normal	0.13	Normal	-0.43	Normal	-0.32	Normal	1	2025-11-20 05:56:18	2025-11-20 05:56:18
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: frisancho_ref; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.frisancho_ref (id, genero, edad_anios, pb_menos_sd, pb_dato, pb_mas_sd, pct_menos_sd, pct_dato, pct_mas_sd, cmb_menos_sd, cmb_dato, cmb_mas_sd, amb_menos_sd, amb_dato, amb_mas_sd, agb_menos_sd, agb_dato, agb_mas_sd, created_at, updated_at) FROM stdin;
1	masculino	5	167.00	175.00	185.00	8.00	9.00	11.00	147.00	154.00	164.00	1550.00	1720.00	1884.00	582.00	713.00	914.00	\N	\N
2	masculino	6	169.00	178.00	188.00	7.00	9.00	12.00	142.00	161.00	184.00	1605.00	1815.00	2056.00	539.00	678.00	896.00	\N	\N
3	masculino	7	177.00	187.00	202.00	7.00	9.00	12.00	151.00	161.00	188.00	1808.00	2027.00	2246.00	574.00	758.00	1011.00	\N	\N
4	masculino	8	177.00	200.00	217.00	8.00	9.00	12.00	154.00	170.00	193.00	1895.00	2089.00	2296.00	588.00	725.00	1003.00	\N	\N
5	masculino	9	187.00	209.00	227.00	8.00	9.00	13.00	161.00	170.00	183.00	2067.00	2288.00	2657.00	635.00	859.00	1252.00	\N	\N
6	masculino	10	196.00	210.00	231.00	8.00	10.00	14.00	166.00	180.00	198.00	2182.00	2575.00	2903.00	738.00	982.00	1376.00	\N	\N
7	masculino	11	202.00	223.00	244.00	8.00	10.00	14.00	173.00	185.00	210.00	2382.00	2670.00	3022.00	754.00	1148.00	1710.00	\N	\N
8	masculino	12	214.00	232.00	253.00	9.00	11.00	14.00	182.00	195.00	210.00	2649.00	3002.00	3496.00	874.00	1172.00	1558.00	\N	\N
9	masculino	13	228.00	247.00	263.00	7.00	10.00	14.00	196.00	211.00	226.00	3044.00	3535.00	4081.00	812.00	1096.00	1702.00	\N	\N
10	masculino	14	241.00	253.00	284.00	7.00	10.00	14.00	212.00	223.00	240.00	3586.00	3963.00	4575.00	786.00	1082.00	1608.00	\N	\N
11	masculino	15	244.00	264.00	284.00	9.00	11.00	14.00	217.00	231.00	246.00	3874.00	4481.00	5134.00	690.00	931.00	1423.00	\N	\N
12	masculino	16	262.00	278.00	303.00	10.00	12.00	15.00	234.00	249.00	265.00	4352.00	4951.00	5753.00	844.00	1078.00	1746.00	\N	\N
13	masculino	17	253.00	267.00	285.00	12.00	13.00	19.00	245.00	258.00	273.00	4777.00	5286.00	5950.00	827.00	1096.00	1636.00	\N	\N
14	masculino	18	260.00	297.00	321.00	12.00	15.00	22.00	260.00	275.00	289.00	5066.00	5552.00	6374.00	860.00	1264.00	1947.00	\N	\N
15	femenino	5	165.00	175.00	185.00	8.00	10.00	12.00	134.00	142.00	151.00	1423.00	1598.00	1825.00	637.00	812.00	991.00	\N	\N
16	femenino	6	170.00	176.00	187.00	8.00	10.00	12.00	135.00	145.00	154.00	1513.00	1685.00	1877.00	638.00	827.00	1009.00	\N	\N
17	femenino	7	174.00	183.00	193.00	9.00	11.00	13.00	141.00	152.00	160.00	1602.00	1815.00	2045.00	706.00	920.00	1135.00	\N	\N
18	femenino	8	183.00	195.00	214.00	9.00	12.00	14.00	145.00	158.00	167.00	1708.00	2023.00	2327.00	759.00	1042.00	1383.00	\N	\N
19	femenino	9	194.00	211.00	224.00	10.00	13.00	16.00	151.00	167.00	180.00	1976.00	2227.00	2571.00	933.00	1219.00	1554.00	\N	\N
20	femenino	10	193.00	210.00	228.00	10.00	12.00	17.00	159.00	170.00	180.00	2019.00	2296.00	2583.00	842.00	1141.00	1608.00	\N	\N
21	femenino	11	208.00	224.00	248.00	10.00	13.00	18.00	158.00	171.00	191.00	2316.00	2612.00	3071.00	1015.00	1301.00	1942.00	\N	\N
22	femenino	12	216.00	237.00	256.00	11.00	14.00	18.00	168.00	180.00	201.00	2579.00	2904.00	3225.00	1090.00	1501.00	2165.00	\N	\N
23	femenino	13	223.00	243.00	271.00	12.00	15.00	21.00	175.00	190.00	202.00	2657.00	3130.00	3529.00	1219.00	1625.00	2374.00	\N	\N
24	femenino	14	237.00	252.00	272.00	13.00	16.00	21.00	189.00	201.00	216.00	2874.00	3220.00	3689.00	1282.00	1818.00	2403.00	\N	\N
25	femenino	15	239.00	254.00	279.00	12.00	17.00	21.00	194.00	209.00	226.00	2847.00	3248.00	3689.00	1396.00	1886.00	2948.00	\N	\N
26	femenino	16	241.00	258.00	283.00	15.00	18.00	22.00	199.00	215.00	232.00	2865.00	3324.00	3683.00	1483.00	1984.00	3283.00	\N	\N
27	femenino	17	241.00	264.00	295.00	13.00	19.00	24.00	194.00	205.00	224.00	2996.00	3336.00	3883.00	1663.00	2066.00	3221.00	\N	\N
28	femenino	18	241.00	258.00	281.00	15.00	18.00	22.00	194.00	202.00	215.00	2917.00	3243.00	3694.00	1616.00	2104.00	2617.00	\N	\N
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: medidas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.medidas (id, paciente_id, fecha, edad_meses, peso_kg, talla_cm, pb_mm, pct_mm, estado, created_at, updated_at) FROM stdin;
2	1	2025-10-24	129	60.00	150.00	223.00	5.00	Activo	2025-10-24 10:14:40	2025-10-24 10:14:40
3	1	2025-10-24	129	60.00	151.00	223.00	7.00	Activo	2025-10-24 20:28:08	2025-10-24 20:28:08
4	2	2025-10-25	129	60.00	150.00	223.00	9.00	Activo	2025-10-25 00:22:12	2025-10-25 00:22:12
5	3	2025-10-25	129	60.00	150.00	235.00	10.00	Activo	2025-10-25 00:32:43	2025-10-25 00:32:43
6	4	2025-10-25	129	60.00	150.00	233.00	9.00	Activo	2025-10-25 00:50:24	2025-10-25 00:50:24
7	5	2025-10-25	129	60.00	150.00	223.00	9.00	Activo	2025-10-25 00:59:34	2025-10-25 00:59:34
8	6	2025-10-25	129	60.00	140.00	223.00	9.00	Activo	2025-10-25 01:12:20	2025-10-25 01:12:20
9	7	2025-10-25	130	60.00	150.00	223.00	9.00	Activo	2025-10-25 01:35:38	2025-10-25 01:35:38
10	1	2025-11-11	130	60.00	160.00	225.00	6.00	Activo	2025-11-11 05:06:24	2025-11-11 05:06:24
11	1	2025-11-11	130	60.00	169.00	225.00	6.00	Activo	2025-11-11 05:16:36	2025-11-11 05:16:36
12	4	2025-11-12	130	50.00	160.00	225.00	7.00	Activo	2025-11-12 03:34:30	2025-11-12 03:34:30
13	8	2025-11-12	189	60.00	160.00	225.00	8.00	Activo	2025-11-12 08:49:42	2025-11-12 08:49:42
14	2	2025-11-12	130	50.00	140.00	210.00	6.00	Activo	2025-11-12 08:59:52	2025-11-12 08:59:52
15	2	2025-11-12	130	70.00	160.00	220.00	8.00	Activo	2025-11-12 09:12:51	2025-11-12 09:12:51
16	2	2025-11-13	130	65.00	160.00	250.00	9.00	Activo	2025-11-13 05:31:50	2025-11-13 05:31:50
17	1	2025-11-13	130	50.00	130.00	190.00	6.00	Activo	2025-11-13 05:41:56	2025-11-13 05:41:56
18	1	2025-11-13	130	67.00	164.00	255.00	8.00	Activo	2025-11-13 05:56:31	2025-11-13 05:56:31
19	8	2025-11-13	189	73.00	170.00	200.00	7.00	Activo	2025-11-13 06:11:46	2025-11-13 06:11:46
20	4	2025-11-13	130	58.00	167.00	230.00	7.00	Activo	2025-11-13 06:48:26	2025-11-13 06:48:26
21	9	2025-11-20	190	65.00	153.00	255.00	7.00	Activo	2025-11-20 05:56:18	2025-11-20 05:56:18
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2025_09_29_050210_create_permission_tables	1
5	2025_10_06_052732_crear_tabla_tutores	1
6	2025_10_06_065144_crear_tabla_pacientes	1
7	2025_10_08_055643_create_seguimientos_table	1
8	2025_10_20_013001_create_oms_ref_table	1
9	2025_10_20_013002_create_frisancho_ref_table	1
10	2025_10_20_013003_create_medidas_table	1
11	2025_10_20_013004_create_evaluaciones_table	1
12	2025_10_24_074402_create_requerimientos_nutricionales_table	1
13	2025_10_24_094008_create_molecula_calorica_table	1
\.


--
-- Data for Name: model_has_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.model_has_permissions (permission_id, model_type, model_id) FROM stdin;
\.


--
-- Data for Name: model_has_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.model_has_roles (role_id, model_type, model_id) FROM stdin;
1	App\\Models\\User	1
2	App\\Models\\User	1
3	App\\Models\\User	1
4	App\\Models\\User	1
5	App\\Models\\User	1
3	App\\Models\\User	2
3	App\\Models\\User	3
3	App\\Models\\User	4
3	App\\Models\\User	5
3	App\\Models\\User	6
5	App\\Models\\User	7
2	App\\Models\\User	8
3	App\\Models\\User	8
5	App\\Models\\User	8
2	App\\Models\\User	9
\.


--
-- Data for Name: molecula_calorica; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.molecula_calorica (id, paciente_id, medida_id, requerimiento_id, peso_kg, talla_cm, kilocalorias_totales, proteinas_g_kg, grasas_g_kg, carbohidratos_g_kg, kilocalorias_proteinas, kilocalorias_grasas, kilocalorias_carbohidratos, porcentaje_proteinas, porcentaje_grasas, porcentaje_carbohidratos, registrado_por, estado, created_at, updated_at) FROM stdin;
2	2	4	3	60.00	150.00	2206.15	1.20	1.02	5.69	288.00	551.54	1366.61	0.13	0.25	0.62	1	inactivo	2025-11-04 06:36:12	2025-11-11 02:51:08
3	4	6	5	60.00	150.00	2353.23	1.20	1.09	6.15	288.00	588.31	1476.92	0.12	0.25	0.63	1	activo	2025-11-04 06:36:19	2025-11-11 02:51:17
1	2	4	3	60.00	150.00	2206.15	1.20	1.02	5.69	288.00	551.54	1366.61	0.13	0.25	0.62	1	inactivo	2025-11-04 06:11:21	2025-11-11 02:51:22
5	2	4	3	60.00	150.00	2206.15	1.20	1.02	5.69	288.00	551.54	1366.61	0.13	0.25	0.62	1	activo	2025-11-11 02:52:20	2025-11-11 02:52:20
6	2	4	8	60.00	150.00	1764.92	1.20	0.98	3.95	288.00	529.48	947.44	0.16	0.30	0.54	1	activo	2025-11-11 23:00:56	2025-11-11 23:00:56
4	2	4	3	60.00	150.00	2206.15	1.20	1.02	5.69	288.00	551.54	1366.61	0.13	0.25	0.62	1	inactivo	2025-11-04 06:49:05	2025-11-11 23:01:18
7	5	7	10	60.00	150.00	2443.74	2.10	1.81	4.01	504.00	977.50	962.24	0.21	0.40	0.39	1	activo	2025-11-12 03:41:16	2025-11-12 03:41:16
8	8	13	11	60.00	160.00	1381.01	1.00	0.72	3.14	240.00	386.68	754.33	0.17	0.28	0.55	1	activo	2025-11-12 08:51:04	2025-11-12 08:51:04
9	2	14	12	50.00	140.00	2167.48	1.40	0.96	7.27	280.00	433.50	1453.98	0.13	0.20	0.67	1	activo	2025-11-12 09:02:00	2025-11-12 09:02:00
10	2	15	\N	70.00	160.00	2269.97	0.70	0.54	6.19	196.00	340.50	1733.47	0.09	0.15	0.76	1	activo	2025-11-12 09:15:31	2025-11-12 09:15:31
11	2	16	14	65.00	160.00	1381.22	0.70	0.42	3.66	182.00	248.62	950.60	0.13	0.18	0.69	1	activo	2025-11-13 05:33:55	2025-11-13 05:33:55
12	1	17	15	50.00	130.00	3341.65	1.50	2.23	10.20	300.00	1002.50	2039.16	0.09	0.30	0.61	1	activo	2025-11-13 05:43:54	2025-11-13 05:43:54
13	1	18	15	67.00	164.00	3341.65	1.70	0.83	8.90	455.60	501.25	2384.80	0.14	0.15	0.71	1	activo	2025-11-13 05:58:11	2025-11-13 05:58:11
14	8	19	17	73.00	170.00	2634.26	0.80	1.04	5.88	233.60	684.91	1715.75	0.09	0.26	0.65	1	activo	2025-11-13 06:14:10	2025-11-13 06:14:10
15	4	20	18	58.00	167.00	2235.67	1.50	0.86	6.21	348.00	447.13	1440.54	0.16	0.20	0.64	1	activo	2025-11-13 06:50:36	2025-11-13 06:50:36
16	9	21	19	65.00	153.00	3070.93	0.70	1.05	8.75	182.00	614.19	2274.74	0.06	0.20	0.74	1	activo	2025-11-20 05:59:20	2025-11-20 05:59:20
\.


--
-- Data for Name: oms_ref; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.oms_ref (id, genero, edad_meses, imc_menos_sd, imc_mediana, imc_mas_sd, talla_menos_sd_cm, talla_mediana_cm, talla_mas_sd_cm, created_at, updated_at) FROM stdin;
1	masculino	61	14.07	15.26	16.65	105.67	110.27	114.86	\N	\N
2	masculino	62	14.07	15.26	16.65	106.18	110.80	115.42	\N	\N
3	masculino	63	14.06	15.26	16.65	106.68	111.33	115.99	\N	\N
4	masculino	64	14.06	15.26	16.66	107.18	111.86	116.55	\N	\N
5	masculino	65	14.06	15.26	16.67	107.68	112.39	117.10	\N	\N
6	masculino	66	14.06	15.26	16.68	108.17	112.91	117.66	\N	\N
7	masculino	67	14.06	15.27	16.69	108.65	113.43	118.20	\N	\N
8	masculino	68	14.06	15.27	16.70	109.14	113.94	118.75	\N	\N
9	masculino	69	14.07	15.28	16.71	109.61	114.45	119.29	\N	\N
10	masculino	70	14.07	15.29	16.73	110.09	114.96	119.82	\N	\N
11	masculino	71	14.08	15.30	16.74	110.56	115.46	120.35	\N	\N
12	masculino	72	14.08	15.31	16.76	111.02	115.95	120.88	\N	\N
13	masculino	73	14.09	15.32	16.78	111.49	116.44	121.40	\N	\N
14	masculino	74	14.10	15.33	16.80	111.95	116.93	121.92	\N	\N
15	masculino	75	14.11	15.34	16.82	112.40	117.42	122.44	\N	\N
16	masculino	76	14.12	15.35	16.84	112.86	117.91	122.95	\N	\N
17	masculino	77	14.13	15.37	16.86	113.31	118.39	123.46	\N	\N
18	masculino	78	14.14	15.38	16.89	113.77	118.87	123.98	\N	\N
19	masculino	79	14.15	15.40	16.91	114.22	119.35	124.49	\N	\N
20	masculino	80	14.16	15.41	16.94	114.66	119.83	125.00	\N	\N
21	masculino	81	14.17	15.43	16.96	115.11	120.31	125.50	\N	\N
22	masculino	82	14.18	15.45	16.99	115.56	120.79	126.01	\N	\N
23	masculino	83	14.20	15.47	17.02	116.01	121.26	126.52	\N	\N
24	masculino	84	14.21	15.48	17.05	116.45	121.73	127.02	\N	\N
25	masculino	85	14.22	15.50	17.08	116.89	122.21	127.52	\N	\N
26	masculino	86	14.24	15.52	17.11	117.33	122.68	128.02	\N	\N
27	masculino	87	14.25	15.54	17.14	117.77	123.14	128.52	\N	\N
28	masculino	88	14.27	15.56	17.17	118.20	123.61	129.02	\N	\N
29	masculino	89	14.28	15.58	17.20	118.64	124.07	129.51	\N	\N
30	masculino	90	14.30	15.60	17.23	119.07	124.54	130.00	\N	\N
31	masculino	91	14.31	15.62	17.26	119.50	125.00	130.49	\N	\N
32	masculino	92	14.33	15.65	17.30	119.93	125.45	130.98	\N	\N
33	masculino	93	14.34	15.67	17.33	120.35	125.91	131.47	\N	\N
34	masculino	94	14.36	15.69	17.37	120.78	126.36	131.95	\N	\N
35	masculino	95	14.38	15.71	17.40	121.20	126.82	132.43	\N	\N
36	masculino	96	14.39	15.74	17.44	121.62	127.27	132.91	\N	\N
37	masculino	97	14.41	15.76	17.47	122.04	127.71	133.39	\N	\N
38	masculino	98	14.43	15.79	17.51	122.45	128.16	133.87	\N	\N
39	masculino	99	14.45	15.81	17.55	122.87	128.60	134.34	\N	\N
40	masculino	100	14.47	15.83	17.59	123.28	129.05	134.82	\N	\N
41	masculino	101	14.48	15.86	17.62	123.69	129.49	135.29	\N	\N
42	masculino	102	14.50	15.89	17.66	124.10	129.93	135.76	\N	\N
43	masculino	103	14.52	15.91	17.70	124.51	130.37	136.23	\N	\N
44	masculino	104	14.54	15.94	17.74	124.92	130.81	136.70	\N	\N
45	masculino	105	14.56	15.97	17.78	125.33	131.25	137.17	\N	\N
46	masculino	106	14.58	15.99	17.82	125.74	131.69	137.64	\N	\N
47	masculino	107	14.60	16.02	17.87	126.15	132.13	138.11	\N	\N
48	masculino	108	14.62	16.05	17.91	126.55	132.57	138.58	\N	\N
49	masculino	109	14.65	16.08	17.95	126.96	133.00	139.05	\N	\N
50	masculino	110	14.67	16.11	18.00	127.37	133.44	139.51	\N	\N
51	masculino	111	14.69	16.14	18.04	127.77	133.88	139.98	\N	\N
52	masculino	112	14.71	16.17	18.09	128.18	134.31	140.45	\N	\N
53	masculino	113	14.74	16.20	18.13	128.59	134.75	140.91	\N	\N
54	masculino	114	14.76	16.23	18.18	128.99	135.18	141.38	\N	\N
55	masculino	115	14.79	16.27	18.23	129.39	135.62	141.84	\N	\N
56	masculino	116	14.81	16.30	18.28	129.80	136.05	142.30	\N	\N
57	masculino	117	14.84	16.34	18.33	130.20	136.48	142.77	\N	\N
58	masculino	118	14.87	16.37	18.38	130.60	136.92	143.23	\N	\N
59	masculino	119	14.90	16.41	18.43	131.00	137.35	143.69	\N	\N
60	masculino	120	14.92	16.44	18.48	131.41	137.78	144.15	\N	\N
61	masculino	121	14.95	16.48	18.53	131.81	138.21	144.62	\N	\N
62	masculino	122	14.98	16.52	18.59	132.21	138.65	145.08	\N	\N
63	masculino	123	15.01	16.56	18.64	132.62	139.08	145.54	\N	\N
64	masculino	124	15.04	16.60	18.70	133.02	139.52	146.01	\N	\N
65	masculino	125	15.07	16.64	18.75	133.43	139.95	146.48	\N	\N
66	masculino	126	15.11	16.68	18.81	133.84	140.40	146.95	\N	\N
67	masculino	127	15.14	16.72	18.87	134.26	140.84	147.42	\N	\N
68	masculino	128	15.17	16.76	18.92	134.67	141.29	147.90	\N	\N
69	masculino	129	15.21	16.81	18.98	135.10	141.74	148.38	\N	\N
70	masculino	130	15.24	16.85	19.04	135.52	142.19	148.86	\N	\N
71	masculino	131	15.28	16.89	19.10	135.95	142.65	149.35	\N	\N
72	masculino	132	15.31	16.94	19.16	136.38	143.11	149.84	\N	\N
73	masculino	133	15.35	16.99	19.22	136.82	143.58	150.34	\N	\N
74	masculino	134	15.39	17.03	19.29	137.26	144.05	150.84	\N	\N
75	masculino	135	15.42	17.08	19.35	137.71	144.53	151.35	\N	\N
76	masculino	136	15.46	17.13	19.41	138.16	145.01	151.86	\N	\N
77	masculino	137	15.50	17.18	19.48	138.62	145.50	152.38	\N	\N
78	masculino	138	15.54	17.22	19.54	139.08	145.99	152.90	\N	\N
79	masculino	139	15.58	17.27	19.61	139.55	146.49	153.43	\N	\N
80	masculino	140	15.62	17.32	19.67	140.03	146.99	153.96	\N	\N
81	masculino	141	15.66	17.38	19.74	140.51	147.50	154.50	\N	\N
82	masculino	142	15.70	17.43	19.81	141.00	148.02	155.05	\N	\N
83	masculino	143	15.75	17.48	19.88	141.49	148.55	155.60	\N	\N
84	masculino	144	15.79	17.53	19.95	142.00	149.08	156.17	\N	\N
85	masculino	145	15.83	17.59	20.02	142.51	149.62	156.74	\N	\N
86	masculino	146	15.88	17.64	20.09	143.02	150.17	157.31	\N	\N
87	masculino	147	15.92	17.70	20.16	143.55	150.73	157.90	\N	\N
88	masculino	148	15.97	17.76	20.23	144.09	151.29	158.49	\N	\N
89	masculino	149	16.02	17.81	20.30	144.63	151.86	159.09	\N	\N
90	masculino	150	16.06	17.87	20.38	145.18	152.44	159.70	\N	\N
91	masculino	151	16.11	17.93	20.45	145.74	153.03	160.32	\N	\N
92	masculino	152	16.16	17.99	20.52	146.31	153.62	160.94	\N	\N
93	masculino	153	16.21	18.05	20.60	146.88	154.22	161.57	\N	\N
94	masculino	154	16.26	18.11	20.68	147.45	154.83	162.20	\N	\N
95	masculino	155	16.31	18.17	20.75	148.03	155.43	162.84	\N	\N
96	masculino	156	16.36	18.23	20.83	148.62	156.04	163.47	\N	\N
97	masculino	157	16.41	18.30	20.91	149.20	156.65	164.11	\N	\N
98	masculino	158	16.47	18.36	20.98	149.79	157.27	164.75	\N	\N
99	masculino	159	16.52	18.42	21.06	150.37	157.88	165.38	\N	\N
100	masculino	160	16.57	18.49	21.14	150.96	158.49	166.02	\N	\N
101	masculino	161	16.63	18.55	21.22	151.54	159.09	166.65	\N	\N
102	masculino	162	16.68	18.62	21.30	152.12	159.70	167.27	\N	\N
103	masculino	163	16.73	18.68	21.38	152.70	160.29	167.89	\N	\N
104	masculino	164	16.79	18.74	21.46	153.27	160.89	168.50	\N	\N
105	masculino	165	16.84	18.81	21.53	153.83	161.47	169.11	\N	\N
106	masculino	166	16.90	18.88	21.61	154.39	162.05	169.71	\N	\N
107	masculino	167	16.95	18.94	21.69	154.95	162.62	170.30	\N	\N
108	masculino	168	17.00	19.01	21.77	155.49	163.18	170.87	\N	\N
109	masculino	169	17.06	19.07	21.85	156.03	163.73	171.44	\N	\N
110	masculino	170	17.11	19.14	21.93	156.55	164.27	171.99	\N	\N
111	masculino	171	17.17	19.20	22.00	157.06	164.80	172.54	\N	\N
112	masculino	172	17.22	19.27	22.08	157.57	165.31	173.06	\N	\N
113	masculino	173	17.28	19.33	22.16	158.06	165.82	173.58	\N	\N
114	masculino	174	17.33	19.39	22.24	158.54	166.31	174.07	\N	\N
115	masculino	175	17.38	19.46	22.31	159.00	166.78	174.56	\N	\N
116	masculino	176	17.44	19.52	22.39	159.46	167.24	175.03	\N	\N
117	masculino	177	17.49	19.59	22.46	159.90	167.69	175.48	\N	\N
118	masculino	178	17.54	19.65	22.54	160.33	168.13	175.92	\N	\N
119	masculino	179	17.59	19.71	22.61	160.75	168.55	176.35	\N	\N
120	masculino	180	17.65	19.77	22.69	161.15	168.96	176.76	\N	\N
121	masculino	181	17.70	19.84	22.76	161.55	169.36	177.16	\N	\N
122	masculino	182	17.75	19.90	22.83	161.93	169.74	177.55	\N	\N
123	masculino	183	17.80	19.96	22.90	162.30	170.11	177.92	\N	\N
124	masculino	184	17.85	20.02	22.98	162.66	170.47	178.27	\N	\N
125	masculino	185	17.90	20.08	23.05	163.01	170.81	178.62	\N	\N
126	masculino	186	17.95	20.14	23.12	163.34	171.15	178.95	\N	\N
127	masculino	187	18.00	20.20	23.19	163.67	171.47	179.27	\N	\N
128	masculino	188	18.05	20.26	23.26	163.98	171.78	179.57	\N	\N
129	masculino	189	18.10	20.32	23.32	164.29	172.08	179.87	\N	\N
130	masculino	190	18.15	20.38	23.39	164.58	172.36	180.14	\N	\N
131	masculino	191	18.20	20.44	23.46	164.86	172.63	180.41	\N	\N
132	masculino	192	18.25	20.50	23.53	165.13	172.90	180.67	\N	\N
133	masculino	193	18.30	20.55	23.59	165.38	173.15	180.91	\N	\N
134	masculino	194	18.34	20.61	23.66	165.63	173.39	181.14	\N	\N
135	masculino	195	18.39	20.66	23.72	165.87	173.61	181.36	\N	\N
136	masculino	196	18.43	20.72	23.79	166.09	173.83	181.57	\N	\N
137	masculino	197	18.48	20.77	23.85	166.31	174.03	181.76	\N	\N
138	masculino	198	18.52	20.83	23.91	166.51	174.23	181.94	\N	\N
139	masculino	199	18.57	20.88	23.97	166.70	174.41	182.11	\N	\N
140	masculino	200	18.61	20.94	24.03	166.89	174.58	182.27	\N	\N
141	masculino	201	18.66	20.99	24.09	167.06	174.74	182.42	\N	\N
142	masculino	202	18.70	21.04	24.15	167.22	174.89	182.56	\N	\N
143	masculino	203	18.74	21.09	24.21	167.37	175.03	182.69	\N	\N
144	masculino	204	18.78	21.14	24.27	167.52	175.16	182.81	\N	\N
145	masculino	205	18.82	21.19	24.33	167.65	175.28	182.91	\N	\N
146	masculino	206	18.86	21.24	24.38	167.78	175.40	183.01	\N	\N
147	masculino	207	18.90	21.29	24.44	167.90	175.50	183.10	\N	\N
148	masculino	208	18.94	21.34	24.49	168.01	175.60	183.19	\N	\N
149	masculino	209	18.98	21.39	24.55	168.11	175.69	183.26	\N	\N
150	masculino	210	19.02	21.44	24.60	168.21	175.77	183.33	\N	\N
151	masculino	211	19.06	21.48	24.66	168.30	175.84	183.39	\N	\N
152	masculino	212	19.10	21.53	24.71	168.38	175.91	183.44	\N	\N
153	masculino	213	19.13	21.57	24.76	168.46	175.98	183.49	\N	\N
154	masculino	214	19.17	21.62	24.81	168.54	176.04	183.54	\N	\N
155	masculino	215	19.21	21.66	24.86	168.61	176.09	183.58	\N	\N
156	masculino	216	19.24	21.71	24.91	168.68	176.15	183.62	\N	\N
157	masculino	217	19.28	21.75	24.96	168.74	176.19	183.65	\N	\N
158	masculino	218	19.31	21.79	25.01	168.80	176.24	183.68	\N	\N
159	masculino	219	19.34	21.84	25.06	168.85	176.28	183.70	\N	\N
160	masculino	220	19.38	21.88	25.10	168.90	176.32	183.73	\N	\N
161	masculino	221	19.41	21.92	25.15	168.95	176.35	183.75	\N	\N
162	masculino	222	19.44	21.96	25.19	169.00	176.39	183.77	\N	\N
163	masculino	223	19.47	22.00	25.24	169.05	176.42	183.79	\N	\N
164	masculino	224	19.50	22.04	25.28	169.09	176.45	183.80	\N	\N
165	masculino	225	19.54	22.08	25.32	169.13	176.47	183.81	\N	\N
166	masculino	226	19.56	22.11	25.37	169.17	176.50	183.82	\N	\N
167	masculino	227	19.59	22.15	25.41	169.21	176.52	183.83	\N	\N
168	masculino	228	19.62	22.19	25.45	169.25	176.54	183.84	\N	\N
169	femenino	61	13.89	15.24	16.87	104.83	109.60	114.38	\N	\N
170	femenino	62	13.89	15.24	16.88	105.32	110.13	114.93	\N	\N
171	femenino	63	13.88	15.24	16.89	105.81	110.65	115.48	\N	\N
172	femenino	64	13.88	15.24	16.90	106.29	111.16	116.03	\N	\N
173	femenino	65	13.87	15.25	16.91	106.77	111.67	116.57	\N	\N
174	femenino	66	13.87	15.25	16.92	107.24	112.18	117.11	\N	\N
175	femenino	67	13.87	15.25	16.94	107.71	112.68	117.64	\N	\N
176	femenino	68	13.86	15.25	16.95	108.18	113.17	118.17	\N	\N
177	femenino	69	13.86	15.26	16.96	108.64	113.67	118.70	\N	\N
178	femenino	70	13.86	15.26	16.98	109.10	114.16	119.22	\N	\N
179	femenino	71	13.86	15.26	17.00	109.55	114.64	119.73	\N	\N
180	femenino	72	13.86	15.27	17.01	110.01	115.12	120.24	\N	\N
181	femenino	73	13.86	15.28	17.03	110.46	115.60	120.75	\N	\N
182	femenino	74	13.87	15.28	17.05	110.90	116.08	121.26	\N	\N
183	femenino	75	13.87	15.29	17.07	111.35	116.56	121.77	\N	\N
184	femenino	76	13.87	15.30	17.09	111.79	117.03	122.27	\N	\N
185	femenino	77	13.87	15.31	17.11	112.24	117.50	122.77	\N	\N
186	femenino	78	13.88	15.32	17.13	112.68	117.98	123.27	\N	\N
187	femenino	79	13.89	15.33	17.15	113.13	118.45	123.77	\N	\N
188	femenino	80	13.89	15.34	17.18	113.57	118.92	124.28	\N	\N
189	femenino	81	13.90	15.36	17.20	114.01	119.39	124.78	\N	\N
190	femenino	82	13.91	15.37	17.23	114.45	119.87	125.28	\N	\N
191	femenino	83	13.92	15.39	17.26	114.90	120.34	125.78	\N	\N
192	femenino	84	13.93	15.40	17.29	115.34	120.81	126.28	\N	\N
193	femenino	85	13.94	15.42	17.32	115.79	121.28	126.78	\N	\N
194	femenino	86	13.95	15.44	17.35	116.24	121.76	127.28	\N	\N
195	femenino	87	13.96	15.46	17.38	116.68	122.23	127.79	\N	\N
196	femenino	88	13.98	15.48	17.42	117.13	122.71	128.29	\N	\N
197	femenino	89	13.99	15.50	17.45	117.58	123.19	128.79	\N	\N
198	femenino	90	14.01	15.52	17.49	118.03	123.67	129.30	\N	\N
199	femenino	91	14.02	15.55	17.53	118.48	124.14	129.81	\N	\N
200	femenino	92	14.04	15.57	17.56	118.93	124.62	130.31	\N	\N
201	femenino	93	14.06	15.60	17.60	119.39	125.10	130.82	\N	\N
202	femenino	94	14.08	15.63	17.65	119.84	125.59	131.33	\N	\N
203	femenino	95	14.10	15.65	17.69	120.30	126.07	131.84	\N	\N
204	femenino	96	14.12	15.68	17.73	120.76	126.56	132.35	\N	\N
205	femenino	97	14.14	15.71	17.77	121.22	127.04	132.87	\N	\N
206	femenino	98	14.16	15.74	17.82	121.68	127.53	133.38	\N	\N
207	femenino	99	14.19	15.77	17.87	122.14	128.02	133.90	\N	\N
208	femenino	100	14.21	15.81	17.91	122.61	128.51	134.42	\N	\N
209	femenino	101	14.24	15.84	17.96	123.07	129.00	134.93	\N	\N
210	femenino	102	14.26	15.87	18.01	123.54	129.50	135.45	\N	\N
211	femenino	103	14.29	15.91	18.06	124.01	129.99	135.98	\N	\N
212	femenino	104	14.32	15.95	18.11	124.48	130.49	136.50	\N	\N
213	femenino	105	14.35	15.98	18.17	124.95	130.99	137.02	\N	\N
214	femenino	106	14.38	16.02	18.22	125.43	131.49	137.55	\N	\N
215	femenino	107	14.40	16.06	18.27	125.91	131.99	138.08	\N	\N
216	femenino	108	14.43	16.10	18.33	126.38	132.49	138.61	\N	\N
217	femenino	109	14.47	16.14	18.38	126.86	133.00	139.13	\N	\N
218	femenino	110	14.50	16.18	18.44	127.35	133.51	139.67	\N	\N
219	femenino	111	14.53	16.22	18.49	127.83	134.01	140.20	\N	\N
220	femenino	112	14.56	16.26	18.55	128.31	134.52	140.73	\N	\N
221	femenino	113	14.59	16.30	18.61	128.80	135.03	141.26	\N	\N
222	femenino	114	14.63	16.34	18.67	129.28	135.54	141.80	\N	\N
223	femenino	115	14.66	16.39	18.73	129.77	136.05	142.34	\N	\N
224	femenino	116	14.69	16.43	18.79	130.26	136.57	142.87	\N	\N
225	femenino	117	14.73	16.48	18.85	130.75	137.08	143.41	\N	\N
226	femenino	118	14.76	16.52	18.91	131.25	137.60	143.95	\N	\N
227	femenino	119	14.80	16.57	18.97	131.74	138.12	144.49	\N	\N
228	femenino	120	14.84	16.61	19.03	132.24	138.64	145.03	\N	\N
229	femenino	121	14.88	16.66	19.10	132.74	139.16	145.58	\N	\N
230	femenino	122	14.91	16.71	19.16	133.24	139.68	146.12	\N	\N
231	femenino	123	14.95	16.76	19.23	133.74	140.21	146.67	\N	\N
232	femenino	124	14.99	16.81	19.29	134.25	140.73	147.22	\N	\N
233	femenino	125	15.04	16.86	19.36	134.75	141.26	147.76	\N	\N
234	femenino	126	15.08	16.91	19.43	135.26	141.79	148.32	\N	\N
235	femenino	127	15.12	16.97	19.50	135.77	142.32	148.87	\N	\N
236	femenino	128	15.16	17.02	19.57	136.29	142.85	149.42	\N	\N
237	femenino	129	15.21	17.08	19.64	136.80	143.39	149.98	\N	\N
238	femenino	130	15.25	17.13	19.71	137.32	143.92	150.53	\N	\N
239	femenino	131	15.30	17.19	19.79	137.83	144.46	151.09	\N	\N
240	femenino	132	15.34	17.25	19.86	138.35	144.99	151.64	\N	\N
241	femenino	133	15.39	17.30	19.93	138.86	145.53	152.19	\N	\N
242	femenino	134	15.44	17.36	20.01	139.38	146.06	152.75	\N	\N
243	femenino	135	15.49	17.42	20.09	139.89	146.60	153.30	\N	\N
244	femenino	136	15.54	17.49	20.16	140.41	147.13	153.85	\N	\N
245	femenino	137	15.59	17.55	20.24	140.92	147.66	154.39	\N	\N
246	femenino	138	15.64	17.61	20.32	141.43	148.18	154.93	\N	\N
247	femenino	139	15.69	17.67	20.40	141.93	148.70	155.47	\N	\N
248	femenino	140	15.74	17.74	20.48	142.44	149.22	156.00	\N	\N
249	femenino	141	15.79	17.80	20.56	142.93	149.73	156.53	\N	\N
250	femenino	142	15.85	17.87	20.64	143.43	150.24	157.05	\N	\N
251	femenino	143	15.90	17.93	20.72	143.91	150.74	157.57	\N	\N
252	femenino	144	15.95	18.00	20.81	144.39	151.23	158.07	\N	\N
253	femenino	145	16.01	18.06	20.89	144.87	151.72	158.57	\N	\N
254	femenino	146	16.06	18.13	20.97	145.33	152.20	159.06	\N	\N
255	femenino	147	16.12	18.20	21.06	145.79	152.66	159.54	\N	\N
256	femenino	148	16.17	18.26	21.14	146.24	153.12	160.01	\N	\N
257	femenino	149	16.23	18.33	21.22	146.67	153.57	160.46	\N	\N
258	femenino	150	16.28	18.40	21.31	147.10	154.00	160.91	\N	\N
259	femenino	151	16.34	18.47	21.39	147.52	154.43	161.34	\N	\N
260	femenino	152	16.39	18.53	21.47	147.92	154.84	161.76	\N	\N
261	femenino	153	16.45	18.60	21.55	148.32	155.24	162.17	\N	\N
262	femenino	154	16.50	18.67	21.64	148.70	155.63	162.57	\N	\N
263	femenino	155	16.56	18.74	21.72	149.07	156.01	162.95	\N	\N
264	femenino	156	16.61	18.80	21.80	149.43	156.38	163.32	\N	\N
265	femenino	157	16.67	18.87	21.88	149.78	156.73	163.67	\N	\N
266	femenino	158	16.72	18.93	21.96	150.12	157.07	164.01	\N	\N
267	femenino	159	16.78	19.00	22.04	150.45	157.39	164.34	\N	\N
268	femenino	160	16.83	19.06	22.12	150.76	157.71	164.66	\N	\N
269	femenino	161	16.88	19.13	22.20	151.06	158.01	164.96	\N	\N
270	femenino	162	16.93	19.19	22.28	151.35	158.30	165.25	\N	\N
271	femenino	163	16.99	19.26	22.36	151.63	158.58	165.53	\N	\N
272	femenino	164	17.04	19.32	22.43	151.89	158.84	165.79	\N	\N
273	femenino	165	17.09	19.38	22.51	152.15	159.10	166.05	\N	\N
274	femenino	166	17.14	19.44	22.58	152.39	159.34	166.29	\N	\N
275	femenino	167	17.19	19.50	22.66	152.62	159.57	166.52	\N	\N
276	femenino	168	17.24	19.57	22.73	152.85	159.79	166.73	\N	\N
277	femenino	169	17.29	19.62	22.80	153.06	160.00	166.94	\N	\N
278	femenino	170	17.33	19.68	22.87	153.26	160.20	167.13	\N	\N
279	femenino	171	17.38	19.74	22.94	153.45	160.39	167.32	\N	\N
280	femenino	172	17.43	19.80	23.01	153.64	160.56	167.49	\N	\N
281	femenino	173	17.47	19.85	23.08	153.81	160.73	167.66	\N	\N
282	femenino	174	17.52	19.91	23.15	153.98	160.89	167.81	\N	\N
283	femenino	175	17.56	19.96	23.21	154.13	161.04	167.96	\N	\N
284	femenino	176	17.60	20.01	23.27	154.28	161.18	168.09	\N	\N
285	femenino	177	17.64	20.07	23.34	154.42	161.32	168.22	\N	\N
286	femenino	178	17.69	20.12	23.40	154.55	161.44	168.34	\N	\N
287	femenino	179	17.73	20.16	23.46	154.67	161.56	168.45	\N	\N
288	femenino	180	17.76	20.21	23.51	154.79	161.67	168.55	\N	\N
289	femenino	181	17.80	20.26	23.57	154.90	161.77	168.64	\N	\N
290	femenino	182	17.84	20.31	23.63	155.00	161.87	168.73	\N	\N
291	femenino	183	17.87	20.35	23.68	155.10	161.96	168.82	\N	\N
292	femenino	184	17.91	20.39	23.73	155.19	162.04	168.89	\N	\N
293	femenino	185	17.94	20.44	23.78	155.27	162.12	168.96	\N	\N
294	femenino	186	17.98	20.48	23.83	155.35	162.19	169.02	\N	\N
295	femenino	187	18.01	20.52	23.88	155.43	162.25	169.08	\N	\N
296	femenino	188	18.04	20.56	23.93	155.50	162.32	169.13	\N	\N
297	femenino	189	18.07	20.59	23.97	155.56	162.37	169.18	\N	\N
298	femenino	190	18.10	20.63	24.02	155.62	162.42	169.23	\N	\N
299	femenino	191	18.13	20.67	24.06	155.68	162.47	169.27	\N	\N
300	femenino	192	18.15	20.70	24.10	155.73	162.52	169.30	\N	\N
301	femenino	193	18.18	20.73	24.14	155.78	162.56	169.34	\N	\N
302	femenino	194	18.21	20.77	24.18	155.82	162.59	169.36	\N	\N
303	femenino	195	18.23	20.80	24.22	155.87	162.63	169.39	\N	\N
304	femenino	196	18.25	20.83	24.25	155.91	162.66	169.41	\N	\N
305	femenino	197	18.28	20.86	24.29	155.94	162.69	169.44	\N	\N
306	femenino	198	18.30	20.89	24.32	155.98	162.72	169.46	\N	\N
307	femenino	199	18.32	20.91	24.36	156.01	162.74	169.47	\N	\N
308	femenino	200	18.34	20.94	24.39	156.05	162.77	169.49	\N	\N
309	femenino	201	18.36	20.97	24.42	156.08	162.79	169.51	\N	\N
310	femenino	202	18.38	20.99	24.45	156.11	162.81	169.52	\N	\N
311	femenino	203	18.39	21.01	24.48	156.14	162.83	169.53	\N	\N
312	femenino	204	18.41	21.04	24.50	156.16	162.85	169.55	\N	\N
313	femenino	205	18.43	21.06	24.53	156.19	162.87	169.56	\N	\N
314	femenino	206	18.44	21.08	24.56	156.22	162.89	169.57	\N	\N
315	femenino	207	18.46	21.10	24.58	156.24	162.91	169.58	\N	\N
316	femenino	208	18.47	21.12	24.60	156.27	162.93	169.59	\N	\N
317	femenino	209	18.49	21.14	24.63	156.29	162.95	169.60	\N	\N
318	femenino	210	18.50	21.16	24.65	156.32	162.97	169.61	\N	\N
319	femenino	211	18.51	21.18	24.67	156.34	162.98	169.62	\N	\N
320	femenino	212	18.53	21.19	24.69	156.36	163.00	169.63	\N	\N
321	femenino	213	18.54	21.21	24.71	156.39	163.01	169.64	\N	\N
322	femenino	214	18.55	21.23	24.73	156.41	163.03	169.65	\N	\N
323	femenino	215	18.56	21.24	24.75	156.43	163.05	169.66	\N	\N
324	femenino	216	18.57	21.26	24.77	156.45	163.06	169.67	\N	\N
325	femenino	217	18.58	21.28	24.79	156.47	163.07	169.68	\N	\N
326	femenino	218	18.59	21.29	24.81	156.49	163.09	169.68	\N	\N
327	femenino	219	18.60	21.31	24.82	156.51	163.10	169.69	\N	\N
328	femenino	220	18.61	21.32	24.84	156.52	163.11	169.69	\N	\N
329	femenino	221	18.62	21.33	24.86	156.54	163.12	169.70	\N	\N
330	femenino	222	18.63	21.35	24.87	156.55	163.13	169.70	\N	\N
331	femenino	223	18.64	21.36	24.89	156.57	163.14	169.70	\N	\N
332	femenino	224	18.65	21.38	24.91	156.58	163.14	169.71	\N	\N
333	femenino	225	18.66	21.39	24.92	156.59	163.15	169.70	\N	\N
334	femenino	226	18.67	21.40	24.94	156.60	163.15	169.70	\N	\N
335	femenino	227	18.67	21.41	24.95	156.61	163.15	169.70	\N	\N
336	femenino	228	18.68	21.43	24.97	156.61	163.16	169.70	\N	\N
\.


--
-- Data for Name: pacientes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pacientes (id, nombre, apellido_paterno, apellido_materno, "CI", fecha_nacimiento, genero, estado, tutor_id, created_at, updated_at) FROM stdin;
1	Vladimir	Azturizaga	Ramos	54637545	2015-01-24	masculino	activo	1	2025-10-24 10:10:54	2025-10-24 10:10:54
2	Alan	Guzman	Ramos	13254871	2015-01-24	masculino	activo	2	2025-10-25 00:21:16	2025-10-25 00:21:16
3	Marco	Villanueva	Ramos	54637511	2015-01-24	masculino	activo	3	2025-10-25 00:32:11	2025-10-25 00:32:11
4	Alan	Villavicencio	Ramos	1298345	2015-01-24	masculino	activo	4	2025-10-25 00:49:49	2025-10-25 00:49:49
5	Mario	Casillas	Lopez	7118345	2015-01-24	masculino	activo	5	2025-10-25 00:59:05	2025-10-25 00:59:05
6	Tereza	Suarez	Sonco	70983411	2015-01-24	femenino	inactivo	6	2025-10-25 01:11:40	2025-11-11 03:10:20
7	Juan	Mealla	Pinto	15254875	2015-01-08	masculino	inactivo	7	2025-10-25 01:35:12	2025-11-12 08:47:40
8	Rodrigo	Perez	Gimenez	11154875	2010-02-12	masculino	activo	8	2025-11-12 08:48:45	2025-11-12 08:48:45
9	Vladimir	Azturizaga	Lopez	13114822	2010-01-20	masculino	activo	9	2025-11-20 05:54:18	2025-11-20 05:54:18
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.permissions (id, name, guard_name, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: requerimientos_nutricionales; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.requerimientos_nutricionales (id, paciente_id, medida_id, peso_kg_at, talla_cm_at, geb_kcal, factor_actividad, factor_lesion, get_kcal, kcal_por_kg, estado, registrado_por, calculado_en, created_at, updated_at) FROM stdin;
1	1	\N	60.00	150.00	1131.36	1.20	1.20	1629.16	27.15	activo	1	2025-10-24 10:11:21	2025-10-24 10:11:21	2025-10-24 10:11:21
2	1	2	60.00	150.00	1131.36	1.20	1.20	1629.16	27.15	activo	1	2025-10-24 21:12:11	2025-10-24 21:12:11	2025-10-24 21:12:11
3	2	4	60.00	150.00	1131.36	1.50	1.30	2206.15	36.77	activo	1	2025-10-25 00:27:18	2025-10-25 00:27:18	2025-10-25 00:27:18
4	3	5	60.00	150.00	1131.36	1.30	1.30	1912.00	31.87	activo	1	2025-10-25 00:37:24	2025-10-25 00:37:24	2025-10-25 00:37:24
5	4	6	60.00	150.00	1131.36	1.30	1.60	2353.23	39.22	activo	3	2025-10-25 01:03:31	2025-10-25 01:03:31	2025-10-25 01:03:31
6	7	9	60.00	150.00	1131.36	1.30	1.20	1764.92	29.42	activo	6	2025-10-25 01:39:07	2025-10-25 01:39:07	2025-10-25 01:39:07
7	2	4	60.44	150.23	1131.82	1.20	1.00	1358.19	22.47	inactivo	1	2025-11-11 03:48:16	2025-11-11 03:48:16	2025-11-11 03:59:35
8	2	4	59.99	150.00	1131.36	1.30	1.20	1764.92	29.42	activo	1	2025-11-11 22:58:42	2025-11-11 22:58:42	2025-11-11 22:58:42
9	2	4	60.00	150.00	1131.36	1.20	1.00	1357.63	22.63	activo	1	2025-11-12 03:38:25	2025-11-12 03:38:25	2025-11-12 03:38:25
10	5	7	60.00	150.00	1131.36	1.20	1.80	2443.74	40.73	activo	1	2025-11-12 03:39:55	2025-11-12 03:39:55	2025-11-12 03:39:55
11	8	13	60.00	160.00	1150.84	1.20	1.00	1381.01	23.02	activo	1	2025-11-12 08:50:24	2025-11-12 08:50:24	2025-11-12 08:50:24
12	2	14	50.00	140.00	1111.53	1.30	1.50	2167.48	43.35	activo	1	2025-11-12 09:00:56	2025-11-12 09:00:56	2025-11-12 09:00:56
14	2	16	65.00	160.00	1151.02	1.20	1.00	1381.22	21.25	activo	1	2025-11-13 05:32:51	2025-11-13 05:32:51	2025-11-13 05:32:51
15	1	17	50.00	130.00	1092.04	1.70	1.80	3341.65	66.83	activo	1	2025-11-13 05:43:07	2025-11-13 05:43:07	2025-11-13 05:43:07
16	4	12	50.00	160.00	1150.49	1.50	1.30	2243.46	44.87	activo	1	2025-11-13 05:57:19	2025-11-13 05:57:19	2025-11-13 05:57:19
17	8	19	73.00	170.00	1170.78	1.50	1.50	2634.26	36.09	activo	1	2025-11-13 06:13:13	2025-11-13 06:13:13	2025-11-13 06:13:13
18	4	20	58.00	167.00	1164.41	1.20	1.60	2235.67	38.55	activo	1	2025-11-13 06:49:46	2025-11-13 06:49:46	2025-11-13 06:49:46
19	9	21	65.00	153.00	1137.38	1.50	1.80	3070.93	47.25	activo	1	2025-11-20 05:58:04	2025-11-20 05:58:04	2025-11-20 05:58:04
20	4	20	58.00	167.00	1164.41	1.20	1.30	1816.48	31.32	activo	1	2025-11-21 21:36:07	2025-11-21 21:36:07	2025-11-21 21:36:07
\.


--
-- Data for Name: role_has_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.role_has_permissions (permission_id, role_id) FROM stdin;
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, name, guard_name, created_at, updated_at) FROM stdin;
1	SuperAdmin	web	2025-10-24 09:44:06	2025-10-24 09:44:06
2	Admin	web	2025-10-24 09:44:06	2025-10-24 09:44:06
3	Nutricionista	web	2025-10-24 09:44:06	2025-10-24 09:44:06
4	Medico	web	2025-10-24 09:44:06	2025-10-24 09:44:06
5	enfermero	web	2025-10-24 09:44:06	2025-10-24 09:44:06
\.


--
-- Data for Name: seguimientos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.seguimientos (id, paciente_id, peso, talla, fecha_seguimiento, estado, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
8FfW2VMV9Riej2HneV7qzKLPsvEs4YWrBhSRNZ0l	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0	YTozOntzOjY6Il90b2tlbiI7czo0MDoiMHJOYzhUak1WWHJ1dHlSMFBSZGw3UTNwNTJQajVGa0NlUkQzYmpjbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2ctdmlld2VyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1765087604
xlczO4ROWu9yRLMf3S2MqSsC7vE2EXyabX5RydPG	1	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0	YTo0OntzOjY6Il90b2tlbiI7czo0MDoia25MYVNpaUdiYklJdEhxMEprVGh2ZmIxNWl5T0RaVlk3TnZ3eFhJViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==	1765168122
2qneMGumhPdxOslIlwuq4c5RgWpjcGXdu9OcRC88	1	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0	YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZk5LZGtBQlRmSVlmVGl0blBaUDRLS3pJc0NpTHFaa0Fac3dkSkJqZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2ctdmlld2VyIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjMxOiJsb2ctdmlld2VyOnNob3J0ZXItc3RhY2stdHJhY2VzIjtiOjA7fQ==	1765089013
PbIFEcVyXzl0tV379SQr5lyv8IPFrszJnN6ycxn1	1	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0	YTo1OntzOjY6Il90b2tlbiI7czo0MDoidENpdkc5V2ZjZGVYNHlnVW14amE2QVVpeTVFNFNvZTBlajd4Z2t4dSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjM6InVybCI7YTowOnt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9	1764884442
86HBxbcmbSD3hnJppKuZp07bzSEeXs38hBexpPAe	1	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVEt6TEF6aWhCWm1qTnhxbkdpbjBCVUxwRWV1emw5eGNNSVFjWmpJOCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9tZWRpZGFzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9	1764884699
lcCzFjgj3c9MA6TEVUApZQOz0nDVd8JedDWCRAmz	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 OPR/124.0.0.0	YTozOntzOjY6Il90b2tlbiI7czo0MDoib3FtbHdXaTUzcGRUQ1U1Mm1jcnNsT1FhMTJPTmVpVFlEanhiT1ZwUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2ctdmlld2VyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1765087820
k4uocZd3bv5npeKajid6lEu0XAPz1C6gxtpoLkXX	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36	YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMkp0akp3Ym0zMVhCVXBXcWxlbjdCOVRabkVDYUJrRXpqMjhib1ladyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2ctdmlld2VyP2ZpbGU9NGRjMWRkZmQtbGFyYXZlbC5sb2ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjMxOiJsb2ctdmlld2VyOnNob3J0ZXItc3RhY2stdHJhY2VzIjtiOjA7fQ==	1765089035
\.


--
-- Data for Name: tutores; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tutores (id, nombre, apellido_paterno, apellido_materno, "CI", telefono, direccion, parentesco, estado, created_at, updated_at) FROM stdin;
1	Carlos	Ramos	Villanueva	3245433	75846912	Bajo Llojeta	madre	activo	2025-10-24 10:10:54	2025-10-24 10:10:54
2	Carlos	Guzman	Villanueva	32454311	75846912	Bajo Llojeta	padre	activo	2025-10-25 00:21:16	2025-10-25 00:21:16
3	Carlos	Villanueva	Ramos	32454322	75846412	Bajo Llojeta	padre	activo	2025-10-25 00:32:11	2025-10-25 00:32:11
4	Carlos	Mamani	Quispe	45781265	75481241	Achumani	padre	activo	2025-10-25 00:49:49	2025-10-25 00:49:49
5	Marco	Casillas	Guzman	45781245	75484411	Achumani	padre	activo	2025-10-25 00:59:05	2025-10-25 00:59:05
6	Marco	Suarez	Pinto	45781266	47584578	Achumani	padre	activo	2025-10-25 01:11:40	2025-10-25 01:11:40
7	Marco	Mealla	Villanueva	32454399	75846900	Bajo Llojeta	padre	activo	2025-10-25 01:35:12	2025-10-25 01:35:12
8	Carlos	Ramos	Villanueva	11454342	75846922	Bajo Llojeta	padre	activo	2025-11-12 08:48:45	2025-11-12 08:48:45
9	Carlos	Soza	Villanueva	3245444	75846900	Bajo Llojeta	padre	activo	2025-11-20 05:54:18	2025-11-20 05:54:18
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, nombre, apellido_paterno, apellido_materno, ci, email, email_verified_at, password, fecha_nacimiento, direccion, telefono, genero, estado, remember_token, created_at, updated_at) FROM stdin;
1	Eric Mauricio	Luna	Pinto	13279782	eric@gmail.com	\N	$2y$12$a.XeVknKyP7g32LECyejvOoHQHJP3LfMm5wf060F44F068t4IWLXW	2005-07-08	Bajo Llojeta	75813102	Masculino	activo	\N	2025-10-24 09:44:06	2025-10-24 09:44:06
2	Maria	Azturizaga	Ramos	13222465	nutricionista@gmail.com	\N	$2y$12$DmH.9p6S9Mq97I7CI9jkWuL775qjg9HfkDAueWXJdoXbtDDsFyurC	2007-09-19	Bajo Llojeta	75822102	femenino	inactivo	\N	2025-10-25 00:48:26	2025-10-25 00:54:34
3	Alan	Luna	Lopez	13852454	nutri@gmail.com	\N	$2y$12$aZchPUkNfjf4hzCgaB1H5.ox.S5Cp5Rafi8U5FG/UrQrCsOy4Hwci	2007-10-07	Bajo Llojeta	75813111	masculino	activo	\N	2025-10-25 00:57:36	2025-10-25 00:57:36
4	Marco	Perez	Mendosa	13852499	nutrio@gmail.com	\N	$2y$12$j00bSWES6ncETZljhTQ7GeEOLkUmamo2M70pGaJ2pOZHxWa6IFe7W	2007-08-23	Bajo Llojeta	71113102	masculino	activo	\N	2025-10-25 01:08:29	2025-10-25 01:08:29
5	Vladimir	Guzman	Pinto	13112465	nutrici@example.com	\N	$2y$12$zJtcEyTr/nemfTSiPH9OduG8EkFGrkjt4tQfIjd5PBdhar4mwMVBy	2007-08-27	Bajo Llojeta	75813132	masculino	activo	\N	2025-10-25 01:10:17	2025-10-25 01:10:17
6	Marco	Mamani	Lopez	19952465	nu@gmail.com	\N	$2y$12$OgcX8WSClgUc3D8FvAzj/utpji7Wk0tcK2D8MVXTIVC2mridhaMb2	2007-09-20	Bajo Llojeta	75813100	masculino	activo	\N	2025-10-25 01:17:03	2025-10-25 01:17:03
7	Eric	Callisaya	Pinto	45747485	eric1@gmail.com	\N	$2y$12$4RSAuEXfIyMML58/DABKHOjflqDXdJ363wGq/qiWgt2c3ZcnW.Eha	2007-10-11	Alto Llojeta	75845263	masculino	activo	\N	2025-10-25 01:21:00	2025-10-25 01:21:00
8	Juan	Azturizaga	Lopez	13852111	n@gmail.com	\N	$2y$12$nMnHq9wMSDtzUsUYCPe1Iu1hAv4UIdNzqfksMFNFTKDxo4meZqyNm	2007-10-09	Bajo Llojeta	75713111	masculino	activo	\N	2025-10-25 01:31:48	2025-10-25 01:31:48
9	Esteban	Quipu	Mendez	12432339	admin@gmail.com	\N	$2y$12$I5FwK9/MfOHLwMRrDPqdTevOgL1jzCGmchD0hdjh13n7BoGv/UDIW	2007-11-02	Plaza España	75848421	masculino	activo	\N	2025-12-04 21:30:06	2025-12-04 21:30:06
\.


--
-- Name: evaluaciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.evaluaciones_id_seq', 20, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: frisancho_ref_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.frisancho_ref_id_seq', 28, true);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: medidas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.medidas_id_seq', 21, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 13, true);


--
-- Name: molecula_calorica_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.molecula_calorica_id_seq', 16, true);


--
-- Name: oms_ref_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.oms_ref_id_seq', 336, true);


--
-- Name: pacientes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pacientes_id_seq', 9, true);


--
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.permissions_id_seq', 1, false);


--
-- Name: requerimientos_nutricionales_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.requerimientos_nutricionales_id_seq', 20, true);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 5, true);


--
-- Name: seguimientos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.seguimientos_id_seq', 1, false);


--
-- Name: tutores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tutores_id_seq', 9, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 9, true);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: evaluaciones evaluaciones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluaciones
    ADD CONSTRAINT evaluaciones_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: frisancho_ref frisancho_ref_genero_edad_anios_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.frisancho_ref
    ADD CONSTRAINT frisancho_ref_genero_edad_anios_unique UNIQUE (genero, edad_anios);


--
-- Name: frisancho_ref frisancho_ref_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.frisancho_ref
    ADD CONSTRAINT frisancho_ref_pkey PRIMARY KEY (id);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: medidas medidas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.medidas
    ADD CONSTRAINT medidas_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: model_has_permissions model_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_pkey PRIMARY KEY (permission_id, model_id, model_type);


--
-- Name: model_has_roles model_has_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_pkey PRIMARY KEY (role_id, model_id, model_type);


--
-- Name: molecula_calorica molecula_calorica_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.molecula_calorica
    ADD CONSTRAINT molecula_calorica_pkey PRIMARY KEY (id);


--
-- Name: oms_ref oms_ref_genero_edad_meses_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oms_ref
    ADD CONSTRAINT oms_ref_genero_edad_meses_unique UNIQUE (genero, edad_meses);


--
-- Name: oms_ref oms_ref_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.oms_ref
    ADD CONSTRAINT oms_ref_pkey PRIMARY KEY (id);


--
-- Name: pacientes pacientes_ci_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pacientes
    ADD CONSTRAINT pacientes_ci_unique UNIQUE ("CI");


--
-- Name: pacientes pacientes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pacientes
    ADD CONSTRAINT pacientes_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: permissions permissions_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- Name: requerimientos_nutricionales requerimientos_nutricionales_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.requerimientos_nutricionales
    ADD CONSTRAINT requerimientos_nutricionales_pkey PRIMARY KEY (id);


--
-- Name: role_has_permissions role_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_pkey PRIMARY KEY (permission_id, role_id);


--
-- Name: roles roles_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: seguimientos seguimientos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seguimientos
    ADD CONSTRAINT seguimientos_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: tutores tutores_ci_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tutores
    ADD CONSTRAINT tutores_ci_unique UNIQUE ("CI");


--
-- Name: tutores tutores_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tutores
    ADD CONSTRAINT tutores_pkey PRIMARY KEY (id);


--
-- Name: users users_ci_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_ci_unique UNIQUE (ci);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: evaluaciones_frisancho_ref_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX evaluaciones_frisancho_ref_id_index ON public.evaluaciones USING btree (frisancho_ref_id);


--
-- Name: evaluaciones_medida_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX evaluaciones_medida_id_index ON public.evaluaciones USING btree (medida_id);


--
-- Name: evaluaciones_oms_ref_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX evaluaciones_oms_ref_id_index ON public.evaluaciones USING btree (oms_ref_id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: model_has_permissions_model_id_model_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX model_has_permissions_model_id_model_type_index ON public.model_has_permissions USING btree (model_id, model_type);


--
-- Name: model_has_roles_model_id_model_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX model_has_roles_model_id_model_type_index ON public.model_has_roles USING btree (model_id, model_type);


--
-- Name: requerimientos_nutricionales_paciente_id_calculado_en_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX requerimientos_nutricionales_paciente_id_calculado_en_index ON public.requerimientos_nutricionales USING btree (paciente_id, calculado_en);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: evaluaciones evaluaciones_frisancho_ref_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluaciones
    ADD CONSTRAINT evaluaciones_frisancho_ref_id_foreign FOREIGN KEY (frisancho_ref_id) REFERENCES public.frisancho_ref(id) ON DELETE RESTRICT;


--
-- Name: evaluaciones evaluaciones_medida_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluaciones
    ADD CONSTRAINT evaluaciones_medida_id_foreign FOREIGN KEY (medida_id) REFERENCES public.medidas(id) ON DELETE CASCADE;


--
-- Name: evaluaciones evaluaciones_oms_ref_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluaciones
    ADD CONSTRAINT evaluaciones_oms_ref_id_foreign FOREIGN KEY (oms_ref_id) REFERENCES public.oms_ref(id) ON DELETE RESTRICT;


--
-- Name: evaluaciones evaluaciones_registrado_por_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evaluaciones
    ADD CONSTRAINT evaluaciones_registrado_por_foreign FOREIGN KEY (registrado_por) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: medidas medidas_paciente_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.medidas
    ADD CONSTRAINT medidas_paciente_id_foreign FOREIGN KEY (paciente_id) REFERENCES public.pacientes(id) ON DELETE CASCADE;


--
-- Name: model_has_permissions model_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: model_has_roles model_has_roles_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: molecula_calorica molecula_calorica_medida_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.molecula_calorica
    ADD CONSTRAINT molecula_calorica_medida_id_foreign FOREIGN KEY (medida_id) REFERENCES public.medidas(id) ON DELETE SET NULL;


--
-- Name: molecula_calorica molecula_calorica_paciente_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.molecula_calorica
    ADD CONSTRAINT molecula_calorica_paciente_id_foreign FOREIGN KEY (paciente_id) REFERENCES public.pacientes(id) ON DELETE CASCADE;


--
-- Name: molecula_calorica molecula_calorica_registrado_por_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.molecula_calorica
    ADD CONSTRAINT molecula_calorica_registrado_por_foreign FOREIGN KEY (registrado_por) REFERENCES public.users(id);


--
-- Name: molecula_calorica molecula_calorica_requerimiento_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.molecula_calorica
    ADD CONSTRAINT molecula_calorica_requerimiento_id_foreign FOREIGN KEY (requerimiento_id) REFERENCES public.requerimientos_nutricionales(id) ON DELETE SET NULL;


--
-- Name: pacientes pacientes_tutor_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pacientes
    ADD CONSTRAINT pacientes_tutor_id_foreign FOREIGN KEY (tutor_id) REFERENCES public.tutores(id) ON DELETE SET NULL;


--
-- Name: requerimientos_nutricionales requerimientos_nutricionales_medida_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.requerimientos_nutricionales
    ADD CONSTRAINT requerimientos_nutricionales_medida_id_foreign FOREIGN KEY (medida_id) REFERENCES public.medidas(id) ON DELETE SET NULL;


--
-- Name: requerimientos_nutricionales requerimientos_nutricionales_paciente_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.requerimientos_nutricionales
    ADD CONSTRAINT requerimientos_nutricionales_paciente_id_foreign FOREIGN KEY (paciente_id) REFERENCES public.pacientes(id) ON DELETE CASCADE;


--
-- Name: requerimientos_nutricionales requerimientos_nutricionales_registrado_por_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.requerimientos_nutricionales
    ADD CONSTRAINT requerimientos_nutricionales_registrado_por_foreign FOREIGN KEY (registrado_por) REFERENCES public.users(id);


--
-- Name: role_has_permissions role_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: seguimientos seguimientos_paciente_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seguimientos
    ADD CONSTRAINT seguimientos_paciente_id_foreign FOREIGN KEY (paciente_id) REFERENCES public.pacientes(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

