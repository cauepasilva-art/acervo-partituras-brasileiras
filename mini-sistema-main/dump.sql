--
-- PostgreSQL database dump
--

\restrict otlxqyIFw8wJm6Pl0bjs9cuis5jVfNrsMyJNaKr8uuMaRFB0oMbwRbgUFA5gNqg

-- Dumped from database version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)
-- Dumped by pg_dump version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)

-- Started on 2026-10-22 08:35:21 UTC

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
-- TOC entry 222 (class 1259 OID 24708)
-- Name: partituras; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.partituras (
    id bigint NOT NULL,
    titulo character varying(200) NOT NULL,
    compositor character varying(200) NOT NULL,
    ano_composicao smallint,
    genero character varying(100),
    instrumentacao text,
    tonalidade character varying(40),
    descricao text,
    fonte_procedencia text,
    situacao_direitos character varying(40) DEFAULT 'pendente'::character varying NOT NULL,
    titular_licenca text,
    nome_arquivo_original character varying(255),
    caminho_arquivo character varying(500),
    mime_type character varying(100),
    tamanho_bytes bigint,
    visivel boolean DEFAULT false NOT NULL,
    criado_por bigint,
    criado_em timestamp with time zone DEFAULT now() NOT NULL,
    atualizado_em timestamp with time zone DEFAULT now() NOT NULL,
    CONSTRAINT ck_ano CHECK (((ano_composicao IS NULL) OR ((ano_composicao >= 1000) AND (ano_composicao <= 2100)))),
    CONSTRAINT ck_direitos CHECK (((situacao_direitos)::text = ANY ((ARRAY['dominio_publico'::character varying, 'licenca_autorizada'::character varying, 'restrito'::character varying, 'pendente'::character varying, 'desconhecido'::character varying])::text[])))
);


ALTER TABLE public.partituras OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 24707)
-- Name: partituras_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.partituras ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.partituras_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 220 (class 1259 OID 24693)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    id bigint NOT NULL,
    email character varying(254) NOT NULL,
    senha_hash character varying(255) NOT NULL,
    criado_em timestamp with time zone DEFAULT now() NOT NULL,
    eh_admin boolean DEFAULT false NOT NULL
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 24692)
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.usuarios ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.usuarios_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 3497 (class 0 OID 24708)
-- Dependencies: 222
-- Data for Name: partituras; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.partituras (id, titulo, compositor, ano_composicao, genero, instrumentacao, tonalidade, descricao, fonte_procedencia, situacao_direitos, titular_licenca, nome_arquivo_original, caminho_arquivo, mime_type, tamanho_bytes, visivel, criado_por, criado_em, atualizado_em) FROM stdin;
9	Preludio N°2 	Heitor Villa Lobos	1940	Moderno/Erudito	Guitarra Clássica	E major	Cinco Prelúdios (todos escritos no mesmo ano) e recebeu o subtítulo de "Melodia capadócia" (ou Homenagem ao Malandro Carioca). Toda a coleção foi estreada mundialmente em Montevidéu alguns anos depois, em dezembro de 1942, pelo violonista Abel Carlevaro.	Classclef	dominio_publico	Público	Preludio No 2 in E by Heitor Villa-Lobos.pdf	../uploads/partitura_6ac4eff55940e3.73046452.pdf	application/pdf	148162	t	1	2026-10-06 09:57:59.7586+00	2026-10-06 09:57:59.7586+00
10	GabiGol	GabiGol	2026	FPS	mouse, teclado e pc gamer	Led RGB	Muito FPS	Eu mesmo	restrito	GabiGol	Preludio No 2 in E by Heitor Villa-Lobos.pdf	../uploads/partitura_6ac50899845b59.32799844.pdf	application/pdf	148162	f	1	2026-10-06 11:43:08.045917+00	2026-10-06 11:43:08.045917+00
11	Voz Ta Rouca 	MC caue da 024	1945	homosexual	tabor de macumba, vela preta, livro de mormon, biblia protestante, foto 3x4 da Grazi Braga, sour do gabigolll e cocô do celis	GemidoMajor	feet don't fail me nowwwwww	da juventude, duvidosa	dominio_publico	MC caue da 024	partituraci.pdf	../uploads/partitura_6ac7d729ae4222.18134197.pdf	application/pdf	37896	t	6	2026-10-08 14:48:31.152636+00	2026-10-08 14:48:31.152636+00
12	as	asd	1234	asd	asd	asd	asd	asd	dominio_publico	asd	teste.pdf	../uploads/partitura_6ad9c7ddaa4ce3.34109124.pdf	application/pdf	25834	t	1	2026-10-22 08:22:53.707063+00	2026-10-22 08:22:53.707063+00
\.


--
-- TOC entry 3495 (class 0 OID 24693)
-- Dependencies: 220
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios (id, email, senha_hash, criado_em, eh_admin) FROM stdin;
2	w@w.com	$2y$12$T3rRQL2.LXg2b6KjFYuXmupOGO3pWuN.rBzRPMw3ISI8ClabkNzKm	2026-10-08 10:13:16.34063+00	f
3	teste@teste	$2y$12$uYSnCi1uVWLXR0fio5mFFeWm8FQkuKM9M5T/GM0L1xwhrCiVOniKK	2026-10-08 14:29:08.496282+00	f
4	teste@teste.com	$2y$12$7afEmvZnKoChDJAhO2KpBudAwbDc8ZQqeG.85MkpLO8XXYfFqV12.	2026-10-08 14:29:18.296911+00	f
6	cauepachutopin@teste.com	$2y$12$yQcen9VbX0/4057j0xjogO5DhuXnbtCzcwNOPEwIHH6VNouZxstNu	2026-10-08 14:33:32.562266+00	f
1	ad@ad.com	$2y$12$QTNKdOrzfepwZuoU1b.C3OURP4KWU9640tuT/NkxQNYoe.n91XZB2	2026-09-29 10:15:42.1292+00	t
7	cauepasilva@gmail.com	$2y$12$UEk55hTEP3i658VCSP0nluZnAAwrd50.r2AbeIen0u2y.L3OR76ne	2026-10-20 08:25:03.515566+00	t
8	123@123.com	$2y$12$4xW./BREjZeuUe8dS9F64O7vCHv97nxiCt.OWCKSFjMiH4eaq9gHS	2026-10-20 08:49:20.989153+00	f
10	1234@1234.com	$2y$12$1qwYTJDzNgK51unMOVZDNOiVmn3ws8haAFeGgSTx/nB9k74VBI7Iq	2026-10-20 16:22:00.967593+00	f
\.


--
-- TOC entry 3503 (class 0 OID 0)
-- Dependencies: 221
-- Name: partituras_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.partituras_id_seq', 12, true);


--
-- TOC entry 3504 (class 0 OID 0)
-- Dependencies: 219
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 10, true);


--
-- TOC entry 3345 (class 2606 OID 24727)
-- Name: partituras partituras_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.partituras
    ADD CONSTRAINT partituras_pkey PRIMARY KEY (id);


--
-- TOC entry 3338 (class 2606 OID 24706)
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- TOC entry 3340 (class 2606 OID 24704)
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- TOC entry 3341 (class 1259 OID 24734)
-- Name: idx_partituras_compositor; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_partituras_compositor ON public.partituras USING btree (lower((compositor)::text));


--
-- TOC entry 3342 (class 1259 OID 24735)
-- Name: idx_partituras_genero; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_partituras_genero ON public.partituras USING btree (genero);


--
-- TOC entry 3343 (class 1259 OID 24733)
-- Name: idx_partituras_titulo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_partituras_titulo ON public.partituras USING btree (lower((titulo)::text));


--
-- TOC entry 3346 (class 2606 OID 24728)
-- Name: partituras partituras_criado_por_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.partituras
    ADD CONSTRAINT partituras_criado_por_fkey FOREIGN KEY (criado_por) REFERENCES public.usuarios(id) ON DELETE SET NULL;


-- Completed on 2026-10-22 08:35:25 UTC

--
-- PostgreSQL database dump complete
--

\unrestrict otlxqyIFw8wJm6Pl0bjs9cuis5jVfNrsMyJNaKr8uuMaRFB0oMbwRbgUFA5gNqg


