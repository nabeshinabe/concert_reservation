--
-- PostgreSQL database dump
--

-- Dumped from database version 14.0
-- Dumped by pg_dump version 14.3

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: コンサート; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."コンサート" (
    "公演番号" character varying(8) NOT NULL,
    "観客予定数" integer,
    "チケット代" integer
);


ALTER TABLE public."コンサート" OWNER TO postgres;

--
-- Name: ホール; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."ホール" (
    "会場名" character varying NOT NULL,
    "ホール名" character varying NOT NULL,
    "収容人数" integer,
    "使用料" integer
);


ALTER TABLE public."ホール" OWNER TO postgres;

--
-- Name: 主催; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."主催" (
    "団体名" character varying NOT NULL,
    "コンサート名" character varying NOT NULL
);


ALTER TABLE public."主催" OWNER TO postgres;

--
-- Name: 予約; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."予約" (
    "識別id" character varying(32) NOT NULL,
    "公演番号" character varying(8) NOT NULL,
    "枚数" integer,
    "購入日時" timestamp without time zone
);


ALTER TABLE public."予約" OWNER TO postgres;

--
-- Name: 企画; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."企画" (
    "コンサート名" character varying NOT NULL,
    "出演者" character varying
);


ALTER TABLE public."企画" OWNER TO postgres;

--
-- Name: 会場; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."会場" (
    "会場名" character varying NOT NULL,
    "住所" character varying,
    "営業開始時刻" time without time zone,
    "営業終了時刻" time without time zone
);


ALTER TABLE public."会場" OWNER TO postgres;

--
-- Name: 公演; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."公演" (
    "公演番号" character varying(8) NOT NULL,
    "会場名" character varying NOT NULL,
    "ホール名" character varying NOT NULL,
    "開演日" date NOT NULL,
    "開演時刻" time without time zone NOT NULL
);


ALTER TABLE public."公演" OWNER TO postgres;

--
-- Name: 概要詳細; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."概要詳細" (
    "会場名" character varying NOT NULL,
    "ホール名" character varying NOT NULL,
    "開演日" date NOT NULL,
    "開場時刻" time without time zone,
    "開演時刻" time without time zone NOT NULL,
    "終演時刻" time without time zone,
    "コンサート名" character varying
);


ALTER TABLE public."概要詳細" OWNER TO postgres;

--
-- Name: 公演一覧; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public."公演一覧" AS
 SELECT "公演"."開演日",
    "公演"."開演時刻",
    "概要詳細"."コンサート名",
    "企画"."出演者",
    "公演"."会場名",
    "公演"."ホール名"
   FROM ((public."公演"
     JOIN public."概要詳細" USING ("会場名", "ホール名", "開演日", "開演時刻"))
     JOIN public."企画" USING ("コンサート名"))
  WHERE ("公演"."開演日" >= now())
  ORDER BY "公演"."開演日", "公演"."開演時刻";


ALTER TABLE public."公演一覧" OWNER TO postgres;

--
-- Name: 団体; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."団体" (
    "団体名" character varying NOT NULL,
    "ジャンル" character varying
);


ALTER TABLE public."団体" OWNER TO postgres;

--
-- Name: 観客; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."観客" (
    "識別id" character varying(32) NOT NULL,
    "名前" character varying,
    "住所" character varying,
    "性別" character varying(2),
    "生年月日" date
);


ALTER TABLE public."観客" OWNER TO postgres;

--
-- Name: 購入チケット; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW public."購入チケット" AS
 SELECT "観客"."識別id",
    "観客"."名前",
    "概要詳細"."コンサート名",
    "公演"."開演日",
    "公演"."開演時刻",
    "公演"."会場名",
    "公演"."ホール名",
    "予約"."枚数",
    ("予約"."枚数" * "コンサート"."チケット代") AS "合計金額"
   FROM ((((public."観客"
     CROSS JOIN public."コンサート")
     JOIN public."予約" USING ("識別id", "公演番号"))
     JOIN public."公演" USING ("公演番号"))
     JOIN public."概要詳細" USING ("会場名", "ホール名", "開演日", "開演時刻"));


ALTER TABLE public."購入チケット" OWNER TO postgres;

--
-- Data for Name: ホール; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."ホール" ("会場名", "ホール名", "収容人数", "使用料") FROM stdin;
ロームシアター京都	メインホール	2005	1005700
ロームシアター京都	サウスホール	716	487100
ロームシアター京都	ノースホール	200	82000
ザ・シンフォニーホール	ホール	1704	1595000
京都コンサートホール	大ホール	1833	1763920
京都コンサートホール	アンサンブルホールムラタ	510	425850
フェスティバルホール	ホール	2700	2200000
滋賀県立芸術劇場 びわ湖ホール	大ホール	1848	1018800
滋賀県立芸術劇場 びわ湖ホール	中ホール	804	509400
滋賀県立芸術劇場 びわ湖ホール	小ホール	323	165600
\.

--
-- Data for Name: 会場; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."会場" ("会場名", "住所", "営業開始時刻", "営業終了時刻") FROM stdin;
京都コンサートホール	京都市左京区下鴨半木町1番地の26	09:00:00	22:00:00
ザ・シンフォニーホール	大阪府大阪市北区大淀南二丁目3-3	09:00:00	21:00:00
ロームシアター京都	京都市左京区岡崎最勝寺町13	09:00:00	22:00:00
フェスティバルホール	大阪市北区中之島2-3-18	09:00:00	22:00:00
滋賀県立芸術劇場 びわ湖ホール	滋賀県大津市打出浜15-1	09:00:00	22:00:00
\.


--
-- Name: コンサート コンサート_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."コンサート"
    ADD CONSTRAINT "コンサート_pkey" PRIMARY KEY ("公演番号");


--
-- Name: ホール ホール_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."ホール"
    ADD CONSTRAINT "ホール_pkey" PRIMARY KEY ("会場名", "ホール名");


--
-- Name: ホール ホール_会場名_ホール名_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."ホール"
    ADD CONSTRAINT "ホール_会場名_ホール名_key" UNIQUE ("会場名", "ホール名");


--
-- Name: 主催 主催_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."主催"
    ADD CONSTRAINT "主催_pkey" PRIMARY KEY ("団体名", "コンサート名");


--
-- Name: 予約 予約_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."予約"
    ADD CONSTRAINT "予約_pkey" PRIMARY KEY ("識別id", "公演番号");


--
-- Name: 企画 企画_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."企画"
    ADD CONSTRAINT "企画_pkey" PRIMARY KEY ("コンサート名");


--
-- Name: 会場 会場_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."会場"
    ADD CONSTRAINT "会場_pkey" PRIMARY KEY ("会場名");


--
-- Name: 公演 公演_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."公演"
    ADD CONSTRAINT "公演_pkey" PRIMARY KEY ("公演番号");


--
-- Name: 公演 公演_会場名_ホール名_開演日_開演時刻_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."公演"
    ADD CONSTRAINT "公演_会場名_ホール名_開演日_開演時刻_key" UNIQUE ("会場名", "ホール名", "開演日", "開演時刻");


--
-- Name: 団体 団体_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."団体"
    ADD CONSTRAINT "団体_pkey" PRIMARY KEY ("団体名");


--
-- Name: 概要詳細 概要詳細_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."概要詳細"
    ADD CONSTRAINT "概要詳細_pkey" PRIMARY KEY ("会場名", "ホール名", "開演日", "開演時刻");


--
-- Name: 観客 観客_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."観客"
    ADD CONSTRAINT "観客_pkey" PRIMARY KEY ("識別id");


--
-- Name: ホール ホール_会場名_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."ホール"
    ADD CONSTRAINT "ホール_会場名_fkey" FOREIGN KEY ("会場名") REFERENCES public."会場"("会場名");


--
-- Name: 主催 主催_コンサート名_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."主催"
    ADD CONSTRAINT "主催_コンサート名_fkey" FOREIGN KEY ("コンサート名") REFERENCES public."企画"("コンサート名");


--
-- Name: 主催 主催_団体名_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."主催"
    ADD CONSTRAINT "主催_団体名_fkey" FOREIGN KEY ("団体名") REFERENCES public."団体"("団体名");


--
-- Name: 予約 予約_公演番号_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."予約"
    ADD CONSTRAINT "予約_公演番号_fkey" FOREIGN KEY ("公演番号") REFERENCES public."コンサート"("公演番号");


--
-- Name: 予約 予約_識別id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."予約"
    ADD CONSTRAINT "予約_識別id_fkey" FOREIGN KEY ("識別id") REFERENCES public."観客"("識別id");


--
-- Name: 公演 公演_会場名_ホール名_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."公演"
    ADD CONSTRAINT "公演_会場名_ホール名_fkey" FOREIGN KEY ("会場名", "ホール名") REFERENCES public."ホール"("会場名", "ホール名");


--
-- Name: 公演 公演_公演番号_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."公演"
    ADD CONSTRAINT "公演_公演番号_fkey" FOREIGN KEY ("公演番号") REFERENCES public."コンサート"("公演番号");


--
-- Name: 概要詳細 概要詳細_コンサート名_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."概要詳細"
    ADD CONSTRAINT "概要詳細_コンサート名_fkey" FOREIGN KEY ("コンサート名") REFERENCES public."企画"("コンサート名");


--
-- Name: 概要詳細 概要詳細_会場名_ホール名_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."概要詳細"
    ADD CONSTRAINT "概要詳細_会場名_ホール名_fkey" FOREIGN KEY ("会場名", "ホール名") REFERENCES public."ホール"("会場名", "ホール名");


--
-- Name: 概要詳細 概要詳細_会場名_ホール名_開演日_開演時刻_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."概要詳細"
    ADD CONSTRAINT "概要詳細_会場名_ホール名_開演日_開演時刻_fkey" FOREIGN KEY ("会場名", "ホール名", "開演日", "開演時刻") REFERENCES public."公演"("会場名", "ホール名", "開演日", "開演時刻");


--
-- PostgreSQL database dump complete
--

