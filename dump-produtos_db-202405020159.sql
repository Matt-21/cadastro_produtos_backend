PGDMP         ;                |            produtos_db %   14.11 (Ubuntu 14.11-0ubuntu0.22.04.1)    15.3     	           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            
           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    16385    produtos_db    DATABASE     s   CREATE DATABASE produtos_db WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'C.UTF-8';
    DROP DATABASE produtos_db;
                postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                postgres    false                       0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                   postgres    false    4                       0    0    SCHEMA public    ACL     Q   REVOKE USAGE ON SCHEMA public FROM PUBLIC;
GRANT ALL ON SCHEMA public TO PUBLIC;
                   postgres    false    4            �            1259    16406    pedidos    TABLE     �   CREATE TABLE public.pedidos (
    id_pedidos integer NOT NULL,
    id_produto integer NOT NULL,
    qtd_vendida character varying(150) NOT NULL,
    valor_total character varying(150) NOT NULL
);
    DROP TABLE public.pedidos;
       public         heap    postgres    false    4            �            1259    16405    pedidos_id_pedidos_seq    SEQUENCE     �   CREATE SEQUENCE public.pedidos_id_pedidos_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.pedidos_id_pedidos_seq;
       public          postgres    false    214    4                       0    0    pedidos_id_pedidos_seq    SEQUENCE OWNED BY     Q   ALTER SEQUENCE public.pedidos_id_pedidos_seq OWNED BY public.pedidos.id_pedidos;
          public          postgres    false    213            �            1259    16394    produtos    TABLE     U  CREATE TABLE public.produtos (
    id_produto integer NOT NULL,
    id_tipo_produto integer NOT NULL,
    nome character varying(150) NOT NULL,
    valor character varying(150) NOT NULL,
    qtd_estoque integer NOT NULL,
    valor_imposto character varying(150),
    caminho character varying(500),
    valor_total character varying(200)
);
    DROP TABLE public.produtos;
       public         heap    postgres    false    4            �            1259    16393    produtos_id_produto_seq    SEQUENCE     �   CREATE SEQUENCE public.produtos_id_produto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.produtos_id_produto_seq;
       public          postgres    false    4    212                       0    0    produtos_id_produto_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.produtos_id_produto_seq OWNED BY public.produtos.id_produto;
          public          postgres    false    211            �            1259    16387    tipoprodutos    TABLE     �   CREATE TABLE public.tipoprodutos (
    id_tipo_produto integer NOT NULL,
    tipo_produto character varying(150) NOT NULL,
    valor_imposto character varying(150) NOT NULL
);
     DROP TABLE public.tipoprodutos;
       public         heap    postgres    false    4            �            1259    16386     tipoprodutos_id_tipo_produto_seq    SEQUENCE     �   CREATE SEQUENCE public.tipoprodutos_id_tipo_produto_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 7   DROP SEQUENCE public.tipoprodutos_id_tipo_produto_seq;
       public          postgres    false    4    210                       0    0     tipoprodutos_id_tipo_produto_seq    SEQUENCE OWNED BY     e   ALTER SEQUENCE public.tipoprodutos_id_tipo_produto_seq OWNED BY public.tipoprodutos.id_tipo_produto;
          public          postgres    false    209            m           2604    16409    pedidos id_pedidos    DEFAULT     x   ALTER TABLE ONLY public.pedidos ALTER COLUMN id_pedidos SET DEFAULT nextval('public.pedidos_id_pedidos_seq'::regclass);
 A   ALTER TABLE public.pedidos ALTER COLUMN id_pedidos DROP DEFAULT;
       public          postgres    false    213    214    214            l           2604    16397    produtos id_produto    DEFAULT     z   ALTER TABLE ONLY public.produtos ALTER COLUMN id_produto SET DEFAULT nextval('public.produtos_id_produto_seq'::regclass);
 B   ALTER TABLE public.produtos ALTER COLUMN id_produto DROP DEFAULT;
       public          postgres    false    212    211    212            k           2604    16390    tipoprodutos id_tipo_produto    DEFAULT     �   ALTER TABLE ONLY public.tipoprodutos ALTER COLUMN id_tipo_produto SET DEFAULT nextval('public.tipoprodutos_id_tipo_produto_seq'::regclass);
 K   ALTER TABLE public.tipoprodutos ALTER COLUMN id_tipo_produto DROP DEFAULT;
       public          postgres    false    209    210    210                      0    16406    pedidos 
   TABLE DATA           S   COPY public.pedidos (id_pedidos, id_produto, qtd_vendida, valor_total) FROM stdin;
    public          postgres    false    214   8"                 0    16394    produtos 
   TABLE DATA           ~   COPY public.produtos (id_produto, id_tipo_produto, nome, valor, qtd_estoque, valor_imposto, caminho, valor_total) FROM stdin;
    public          postgres    false    212   h"                 0    16387    tipoprodutos 
   TABLE DATA           T   COPY public.tipoprodutos (id_tipo_produto, tipo_produto, valor_imposto) FROM stdin;
    public          postgres    false    210   #                  0    0    pedidos_id_pedidos_seq    SEQUENCE SET     E   SELECT pg_catalog.setval('public.pedidos_id_pedidos_seq', 44, true);
          public          postgres    false    213                       0    0    produtos_id_produto_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.produtos_id_produto_seq', 14, true);
          public          postgres    false    211                       0    0     tipoprodutos_id_tipo_produto_seq    SEQUENCE SET     O   SELECT pg_catalog.setval('public.tipoprodutos_id_tipo_produto_seq', 41, true);
          public          postgres    false    209            s           2606    16411    pedidos pedidos_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_pkey PRIMARY KEY (id_pedidos);
 >   ALTER TABLE ONLY public.pedidos DROP CONSTRAINT pedidos_pkey;
       public            postgres    false    214            q           2606    16399    produtos produtos_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.produtos
    ADD CONSTRAINT produtos_pkey PRIMARY KEY (id_produto);
 @   ALTER TABLE ONLY public.produtos DROP CONSTRAINT produtos_pkey;
       public            postgres    false    212            o           2606    16392    tipoprodutos tipoprodutos_pkey 
   CONSTRAINT     i   ALTER TABLE ONLY public.tipoprodutos
    ADD CONSTRAINT tipoprodutos_pkey PRIMARY KEY (id_tipo_produto);
 H   ALTER TABLE ONLY public.tipoprodutos DROP CONSTRAINT tipoprodutos_pkey;
       public            postgres    false    210            u           2606    16412    pedidos pedidos_id_produto_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.pedidos
    ADD CONSTRAINT pedidos_id_produto_fkey FOREIGN KEY (id_produto) REFERENCES public.produtos(id_produto);
 I   ALTER TABLE ONLY public.pedidos DROP CONSTRAINT pedidos_id_produto_fkey;
       public          postgres    false    3185    212    214            t           2606    16400 &   produtos produtos_id_tipo_produto_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.produtos
    ADD CONSTRAINT produtos_id_tipo_produto_fkey FOREIGN KEY (id_tipo_produto) REFERENCES public.tipoprodutos(id_tipo_produto);
 P   ALTER TABLE ONLY public.produtos DROP CONSTRAINT produtos_id_tipo_produto_fkey;
       public          postgres    false    210    3183    212                   x�31�44�4�R1ױ00�30������ 1��         �   x�M�1� ���~�-��v4M�t01�iC����d����;v .`2>��>g��R
,�6]�ڜ׷�D�M���U�z��Dr �18���g� �,h;�C�,9�:�L�`p�Ϥ�~�(�*u�_m�~]�+y�d�Ԉ���4}         J   x�31�tN̬HTHIU���46P�2�t�I-)�O��=���$39����(n�����������ih������ ���     