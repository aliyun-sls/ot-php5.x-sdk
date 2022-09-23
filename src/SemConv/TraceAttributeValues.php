<?php

// DO NOT EDIT, this is an Auto-generated file from script/semantic-convention/templates/AttributeValues.php.j2



namespace OpenTelemetry\SemConv;

interface TraceAttributeValues
{
    /**
     * The URL of the OpenTelemetry schema for these keys and values.
     */
     const SCHEMA_URL = 'https://opentelemetry.io/schemas/1.12.0';
    /**
     * @see TraceAttributes::OPENTRACING_REF_TYPE The parent Span depends on the child Span in some capacity
     */
     const OPENTRACING_REF_TYPE_CHILD_OF = 'child_of';

    /**
     * @see TraceAttributes::OPENTRACING_REF_TYPE The parent Span does not depend in any way on the result of the child Span
     */
     const OPENTRACING_REF_TYPE_FOLLOWS_FROM = 'follows_from';

    /**
     * @see TraceAttributes::DB_SYSTEM Some other SQL database. Fallback only. See notes
     */
     const DB_SYSTEM_OTHER_SQL = 'other_sql';

    /**
     * @see TraceAttributes::DB_SYSTEM Microsoft SQL Server
     */
     const DB_SYSTEM_MSSQL = 'mssql';

    /**
     * @see TraceAttributes::DB_SYSTEM MySQL
     */
     const DB_SYSTEM_MYSQL = 'mysql';

    /**
     * @see TraceAttributes::DB_SYSTEM Oracle Database
     */
     const DB_SYSTEM_ORACLE = 'oracle';

    /**
     * @see TraceAttributes::DB_SYSTEM IBM Db2
     */
     const DB_SYSTEM_DB2 = 'db2';

    /**
     * @see TraceAttributes::DB_SYSTEM PostgreSQL
     */
     const DB_SYSTEM_POSTGRESQL = 'postgresql';

    /**
     * @see TraceAttributes::DB_SYSTEM Amazon Redshift
     */
     const DB_SYSTEM_REDSHIFT = 'redshift';

    /**
     * @see TraceAttributes::DB_SYSTEM Apache Hive
     */
     const DB_SYSTEM_HIVE = 'hive';

    /**
     * @see TraceAttributes::DB_SYSTEM Cloudscape
     */
     const DB_SYSTEM_CLOUDSCAPE = 'cloudscape';

    /**
     * @see TraceAttributes::DB_SYSTEM HyperSQL DataBase
     */
     const DB_SYSTEM_HSQLDB = 'hsqldb';

    /**
     * @see TraceAttributes::DB_SYSTEM Progress Database
     */
     const DB_SYSTEM_PROGRESS = 'progress';

    /**
     * @see TraceAttributes::DB_SYSTEM SAP MaxDB
     */
     const DB_SYSTEM_MAXDB = 'maxdb';

    /**
     * @see TraceAttributes::DB_SYSTEM SAP HANA
     */
     const DB_SYSTEM_HANADB = 'hanadb';

    /**
     * @see TraceAttributes::DB_SYSTEM Ingres
     */
     const DB_SYSTEM_INGRES = 'ingres';

    /**
     * @see TraceAttributes::DB_SYSTEM FirstSQL
     */
     const DB_SYSTEM_FIRSTSQL = 'firstsql';

    /**
     * @see TraceAttributes::DB_SYSTEM EnterpriseDB
     */
     const DB_SYSTEM_EDB = 'edb';

    /**
     * @see TraceAttributes::DB_SYSTEM InterSystems Caché
     */
     const DB_SYSTEM_CACHE = 'cache';

    /**
     * @see TraceAttributes::DB_SYSTEM Adabas (Adaptable Database System)
     */
     const DB_SYSTEM_ADABAS = 'adabas';

    /**
     * @see TraceAttributes::DB_SYSTEM Firebird
     */
     const DB_SYSTEM_FIREBIRD = 'firebird';

    /**
     * @see TraceAttributes::DB_SYSTEM Apache Derby
     */
     const DB_SYSTEM_DERBY = 'derby';

    /**
     * @see TraceAttributes::DB_SYSTEM FileMaker
     */
     const DB_SYSTEM_FILEMAKER = 'filemaker';

    /**
     * @see TraceAttributes::DB_SYSTEM Informix
     */
     const DB_SYSTEM_INFORMIX = 'informix';

    /**
     * @see TraceAttributes::DB_SYSTEM InstantDB
     */
     const DB_SYSTEM_INSTANTDB = 'instantdb';

    /**
     * @see TraceAttributes::DB_SYSTEM InterBase
     */
     const DB_SYSTEM_INTERBASE = 'interbase';

    /**
     * @see TraceAttributes::DB_SYSTEM MariaDB
     */
     const DB_SYSTEM_MARIADB = 'mariadb';

    /**
     * @see TraceAttributes::DB_SYSTEM Netezza
     */
     const DB_SYSTEM_NETEZZA = 'netezza';

    /**
     * @see TraceAttributes::DB_SYSTEM Pervasive PSQL
     */
     const DB_SYSTEM_PERVASIVE = 'pervasive';

    /**
     * @see TraceAttributes::DB_SYSTEM PointBase
     */
     const DB_SYSTEM_POINTBASE = 'pointbase';

    /**
     * @see TraceAttributes::DB_SYSTEM SQLite
     */
     const DB_SYSTEM_SQLITE = 'sqlite';

    /**
     * @see TraceAttributes::DB_SYSTEM Sybase
     */
     const DB_SYSTEM_SYBASE = 'sybase';

    /**
     * @see TraceAttributes::DB_SYSTEM Teradata
     */
     const DB_SYSTEM_TERADATA = 'teradata';

    /**
     * @see TraceAttributes::DB_SYSTEM Vertica
     */
     const DB_SYSTEM_VERTICA = 'vertica';

    /**
     * @see TraceAttributes::DB_SYSTEM H2
     */
     const DB_SYSTEM_H2 = 'h2';

    /**
     * @see TraceAttributes::DB_SYSTEM ColdFusion IMQ
     */
     const DB_SYSTEM_COLDFUSION = 'coldfusion';

    /**
     * @see TraceAttributes::DB_SYSTEM Apache Cassandra
     */
     const DB_SYSTEM_CASSANDRA = 'cassandra';

    /**
     * @see TraceAttributes::DB_SYSTEM Apache HBase
     */
     const DB_SYSTEM_HBASE = 'hbase';

    /**
     * @see TraceAttributes::DB_SYSTEM MongoDB
     */
     const DB_SYSTEM_MONGODB = 'mongodb';

    /**
     * @see TraceAttributes::DB_SYSTEM Redis
     */
     const DB_SYSTEM_REDIS = 'redis';

    /**
     * @see TraceAttributes::DB_SYSTEM Couchbase
     */
     const DB_SYSTEM_COUCHBASE = 'couchbase';

    /**
     * @see TraceAttributes::DB_SYSTEM CouchDB
     */
     const DB_SYSTEM_COUCHDB = 'couchdb';

    /**
     * @see TraceAttributes::DB_SYSTEM Microsoft Azure Cosmos DB
     */
     const DB_SYSTEM_COSMOSDB = 'cosmosdb';

    /**
     * @see TraceAttributes::DB_SYSTEM Amazon DynamoDB
     */
     const DB_SYSTEM_DYNAMODB = 'dynamodb';

    /**
     * @see TraceAttributes::DB_SYSTEM Neo4j
     */
     const DB_SYSTEM_NEO4J = 'neo4j';

    /**
     * @see TraceAttributes::DB_SYSTEM Apache Geode
     */
     const DB_SYSTEM_GEODE = 'geode';

    /**
     * @see TraceAttributes::DB_SYSTEM Elasticsearch
     */
     const DB_SYSTEM_ELASTICSEARCH = 'elasticsearch';

    /**
     * @see TraceAttributes::DB_SYSTEM Memcached
     */
     const DB_SYSTEM_MEMCACHED = 'memcached';

    /**
     * @see TraceAttributes::DB_SYSTEM CockroachDB
     */
     const DB_SYSTEM_COCKROACHDB = 'cockroachdb';

    /**
     * @see TraceAttributes::NET_TRANSPORT ip_tcp
     */
     const NET_TRANSPORT_IP_TCP = 'ip_tcp';

    /**
     * @see TraceAttributes::NET_TRANSPORT ip_udp
     */
     const NET_TRANSPORT_IP_UDP = 'ip_udp';

    /**
     * @see TraceAttributes::NET_TRANSPORT Another IP-based protocol
     */
     const NET_TRANSPORT_IP = 'ip';

    /**
     * @see TraceAttributes::NET_TRANSPORT Unix Domain socket. See below
     */
     const NET_TRANSPORT_UNIX = 'unix';

    /**
     * @see TraceAttributes::NET_TRANSPORT Named or anonymous pipe. See note below
     */
     const NET_TRANSPORT_PIPE = 'pipe';

    /**
     * @see TraceAttributes::NET_TRANSPORT In-process communication
     *
     * Signals that there is only in-process communication not using a &quot;real&quot; network protocol in cases where network attributes would normally be expected. Usually all other network attributes can be left out in that case.
     */
     const NET_TRANSPORT_INPROC = 'inproc';

    /**
     * @see TraceAttributes::NET_TRANSPORT Something else (non IP-based)
     */
     const NET_TRANSPORT_OTHER = 'other';

    /**
     * @see TraceAttributes::DB_CASSANDRA_CONSISTENCY_LEVEL all
     */
     const DB_CASSANDRA_CONSISTENCY_LEVEL_ALL = 'all';

    /**
     * @see TraceAttributes::DB_CASSANDRA_CONSISTENCY_LEVEL each_quorum
     */
     const DB_CASSANDRA_CONSISTENCY_LEVEL_EACH_QUORUM = 'each_quorum';

    /**
     * @see TraceAttributes::DB_CASSANDRA_CONSISTENCY_LEVEL quorum
     */
     const DB_CASSANDRA_CONSISTENCY_LEVEL_QUORUM = 'quorum';

    /**
     * @see TraceAttributes::DB_CASSANDRA_CONSISTENCY_LEVEL local_quorum
     */
     const DB_CASSANDRA_CONSISTENCY_LEVEL_LOCAL_QUORUM = 'local_quorum';

    /**
     * @see TraceAttributes::DB_CASSANDRA_CONSISTENCY_LEVEL one
     */
     const DB_CASSANDRA_CONSISTENCY_LEVEL_ONE = 'one';

    /**
     * @see TraceAttributes::DB_CASSANDRA_CONSISTENCY_LEVEL two
     */
     const DB_CASSANDRA_CONSISTENCY_LEVEL_TWO = 'two';

    /**
     * @see TraceAttributes::DB_CASSANDRA_CONSISTENCY_LEVEL three
     */
     const DB_CASSANDRA_CONSISTENCY_LEVEL_THREE = 'three';

    /**
     * @see TraceAttributes::DB_CASSANDRA_CONSISTENCY_LEVEL local_one
     */
     const DB_CASSANDRA_CONSISTENCY_LEVEL_LOCAL_ONE = 'local_one';

    /**
     * @see TraceAttributes::DB_CASSANDRA_CONSISTENCY_LEVEL any
     */
     const DB_CASSANDRA_CONSISTENCY_LEVEL_ANY = 'any';

    /**
     * @see TraceAttributes::DB_CASSANDRA_CONSISTENCY_LEVEL serial
     */
     const DB_CASSANDRA_CONSISTENCY_LEVEL_SERIAL = 'serial';

    /**
     * @see TraceAttributes::DB_CASSANDRA_CONSISTENCY_LEVEL local_serial
     */
     const DB_CASSANDRA_CONSISTENCY_LEVEL_LOCAL_SERIAL = 'local_serial';

    /**
     * @see TraceAttributes::FAAS_TRIGGER A response to some data source operation such as a database or filesystem read/write
     */
     const FAAS_TRIGGER_DATASOURCE = 'datasource';

    /**
     * @see TraceAttributes::FAAS_TRIGGER To provide an answer to an inbound HTTP request
     */
     const FAAS_TRIGGER_HTTP = 'http';

    /**
     * @see TraceAttributes::FAAS_TRIGGER A function is set to be executed when messages are sent to a messaging system
     */
     const FAAS_TRIGGER_PUBSUB = 'pubsub';

    /**
     * @see TraceAttributes::FAAS_TRIGGER A function is scheduled to be executed regularly
     */
     const FAAS_TRIGGER_TIMER = 'timer';

    /**
     * @see TraceAttributes::FAAS_TRIGGER If none of the others apply
     */
     const FAAS_TRIGGER_OTHER = 'other';

    /**
     * @see TraceAttributes::FAAS_DOCUMENT_OPERATION When a new object is created
     */
     const FAAS_DOCUMENT_OPERATION_INSERT = 'insert';

    /**
     * @see TraceAttributes::FAAS_DOCUMENT_OPERATION When an object is modified
     */
     const FAAS_DOCUMENT_OPERATION_EDIT = 'edit';

    /**
     * @see TraceAttributes::FAAS_DOCUMENT_OPERATION When an object is deleted
     */
     const FAAS_DOCUMENT_OPERATION_DELETE = 'delete';

    /**
     * @see TraceAttributes::HTTP_FLAVOR HTTP/1.0
     */
     const HTTP_FLAVOR_HTTP_1_0 = '1.0';

    /**
     * @see TraceAttributes::HTTP_FLAVOR HTTP/1.1
     */
     const HTTP_FLAVOR_HTTP_1_1 = '1.1';

    /**
     * @see TraceAttributes::HTTP_FLAVOR HTTP/2
     */
     const HTTP_FLAVOR_HTTP_2_0 = '2.0';

    /**
     * @see TraceAttributes::HTTP_FLAVOR HTTP/3
     */
     const HTTP_FLAVOR_HTTP_3_0 = '3.0';

    /**
     * @see TraceAttributes::HTTP_FLAVOR SPDY protocol
     */
     const HTTP_FLAVOR_SPDY = 'SPDY';

    /**
     * @see TraceAttributes::HTTP_FLAVOR QUIC protocol
     */
     const HTTP_FLAVOR_QUIC = 'QUIC';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_TYPE wifi
     */
     const NET_HOST_CONNECTION_TYPE_WIFI = 'wifi';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_TYPE wired
     */
     const NET_HOST_CONNECTION_TYPE_WIRED = 'wired';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_TYPE cell
     */
     const NET_HOST_CONNECTION_TYPE_CELL = 'cell';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_TYPE unavailable
     */
     const NET_HOST_CONNECTION_TYPE_UNAVAILABLE = 'unavailable';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_TYPE unknown
     */
     const NET_HOST_CONNECTION_TYPE_UNKNOWN = 'unknown';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE GPRS
     */
     const NET_HOST_CONNECTION_SUBTYPE_GPRS = 'gprs';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE EDGE
     */
     const NET_HOST_CONNECTION_SUBTYPE_EDGE = 'edge';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE UMTS
     */
     const NET_HOST_CONNECTION_SUBTYPE_UMTS = 'umts';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE CDMA
     */
     const NET_HOST_CONNECTION_SUBTYPE_CDMA = 'cdma';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE EVDO Rel. 0
     */
     const NET_HOST_CONNECTION_SUBTYPE_EVDO_0 = 'evdo_0';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE EVDO Rev. A
     */
     const NET_HOST_CONNECTION_SUBTYPE_EVDO_A = 'evdo_a';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE CDMA2000 1XRTT
     */
     const NET_HOST_CONNECTION_SUBTYPE_CDMA2000_1XRTT = 'cdma2000_1xrtt';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE HSDPA
     */
     const NET_HOST_CONNECTION_SUBTYPE_HSDPA = 'hsdpa';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE HSUPA
     */
     const NET_HOST_CONNECTION_SUBTYPE_HSUPA = 'hsupa';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE HSPA
     */
     const NET_HOST_CONNECTION_SUBTYPE_HSPA = 'hspa';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE IDEN
     */
     const NET_HOST_CONNECTION_SUBTYPE_IDEN = 'iden';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE EVDO Rev. B
     */
     const NET_HOST_CONNECTION_SUBTYPE_EVDO_B = 'evdo_b';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE LTE
     */
     const NET_HOST_CONNECTION_SUBTYPE_LTE = 'lte';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE EHRPD
     */
     const NET_HOST_CONNECTION_SUBTYPE_EHRPD = 'ehrpd';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE HSPAP
     */
     const NET_HOST_CONNECTION_SUBTYPE_HSPAP = 'hspap';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE GSM
     */
     const NET_HOST_CONNECTION_SUBTYPE_GSM = 'gsm';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE TD-SCDMA
     */
     const NET_HOST_CONNECTION_SUBTYPE_TD_SCDMA = 'td_scdma';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE IWLAN
     */
     const NET_HOST_CONNECTION_SUBTYPE_IWLAN = 'iwlan';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE 5G NR (New Radio)
     */
     const NET_HOST_CONNECTION_SUBTYPE_NR = 'nr';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE 5G NRNSA (New Radio Non-Standalone)
     */
     const NET_HOST_CONNECTION_SUBTYPE_NRNSA = 'nrnsa';

    /**
     * @see TraceAttributes::NET_HOST_CONNECTION_SUBTYPE LTE CA
     */
     const NET_HOST_CONNECTION_SUBTYPE_LTE_CA = 'lte_ca';

    /**
     * @see TraceAttributes::MESSAGING_DESTINATION_KIND A message sent to a queue
     */
     const MESSAGING_DESTINATION_KIND_QUEUE = 'queue';

    /**
     * @see TraceAttributes::MESSAGING_DESTINATION_KIND A message sent to a topic
     */
     const MESSAGING_DESTINATION_KIND_TOPIC = 'topic';

    /**
     * @see TraceAttributes::FAAS_INVOKED_PROVIDER Alibaba Cloud
     */
     const FAAS_INVOKED_PROVIDER_ALIBABA_CLOUD = 'alibaba_cloud';

    /**
     * @see TraceAttributes::FAAS_INVOKED_PROVIDER Amazon Web Services
     */
     const FAAS_INVOKED_PROVIDER_AWS = 'aws';

    /**
     * @see TraceAttributes::FAAS_INVOKED_PROVIDER Microsoft Azure
     */
     const FAAS_INVOKED_PROVIDER_AZURE = 'azure';

    /**
     * @see TraceAttributes::FAAS_INVOKED_PROVIDER Google Cloud Platform
     */
     const FAAS_INVOKED_PROVIDER_GCP = 'gcp';

    /**
     * @see TraceAttributes::FAAS_INVOKED_PROVIDER Tencent Cloud
     */
     const FAAS_INVOKED_PROVIDER_TENCENT_CLOUD = 'tencent_cloud';

    /**
     * @see TraceAttributes::RPC_SYSTEM gRPC
     */
     const RPC_SYSTEM_GRPC = 'grpc';

    /**
     * @see TraceAttributes::RPC_SYSTEM Java RMI
     */
     const RPC_SYSTEM_JAVA_RMI = 'java_rmi';

    /**
     * @see TraceAttributes::RPC_SYSTEM .NET WCF
     */
     const RPC_SYSTEM_DOTNET_WCF = 'dotnet_wcf';

    /**
     * @see TraceAttributes::RPC_SYSTEM Apache Dubbo
     */
     const RPC_SYSTEM_APACHE_DUBBO = 'apache_dubbo';

    /**
     * @see TraceAttributes::MESSAGING_OPERATION receive
     */
     const MESSAGING_OPERATION_RECEIVE = 'receive';

    /**
     * @see TraceAttributes::MESSAGING_OPERATION process
     */
     const MESSAGING_OPERATION_PROCESS = 'process';

    /**
     * @see TraceAttributes::MESSAGING_ROCKETMQ_MESSAGE_TYPE Normal message
     */
     const MESSAGING_ROCKETMQ_MESSAGE_TYPE_NORMAL = 'normal';

    /**
     * @see TraceAttributes::MESSAGING_ROCKETMQ_MESSAGE_TYPE FIFO message
     */
     const MESSAGING_ROCKETMQ_MESSAGE_TYPE_FIFO = 'fifo';

    /**
     * @see TraceAttributes::MESSAGING_ROCKETMQ_MESSAGE_TYPE Delay message
     */
     const MESSAGING_ROCKETMQ_MESSAGE_TYPE_DELAY = 'delay';

    /**
     * @see TraceAttributes::MESSAGING_ROCKETMQ_MESSAGE_TYPE Transaction message
     */
     const MESSAGING_ROCKETMQ_MESSAGE_TYPE_TRANSACTION = 'transaction';

    /**
     * @see TraceAttributes::MESSAGING_ROCKETMQ_CONSUMPTION_MODEL Clustering consumption model
     */
     const MESSAGING_ROCKETMQ_CONSUMPTION_MODEL_CLUSTERING = 'clustering';

    /**
     * @see TraceAttributes::MESSAGING_ROCKETMQ_CONSUMPTION_MODEL Broadcasting consumption model
     */
     const MESSAGING_ROCKETMQ_CONSUMPTION_MODEL_BROADCASTING = 'broadcasting';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE OK
     */
     const RPC_GRPC_STATUS_CODE_OK = '0';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE CANCELLED
     */
     const RPC_GRPC_STATUS_CODE_CANCELLED = '1';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE UNKNOWN
     */
     const RPC_GRPC_STATUS_CODE_UNKNOWN = '2';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE INVALID_ARGUMENT
     */
     const RPC_GRPC_STATUS_CODE_INVALID_ARGUMENT = '3';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE DEADLINE_EXCEEDED
     */
     const RPC_GRPC_STATUS_CODE_DEADLINE_EXCEEDED = '4';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE NOT_FOUND
     */
     const RPC_GRPC_STATUS_CODE_NOT_FOUND = '5';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE ALREADY_EXISTS
     */
     const RPC_GRPC_STATUS_CODE_ALREADY_EXISTS = '6';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE PERMISSION_DENIED
     */
     const RPC_GRPC_STATUS_CODE_PERMISSION_DENIED = '7';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE RESOURCE_EXHAUSTED
     */
     const RPC_GRPC_STATUS_CODE_RESOURCE_EXHAUSTED = '8';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE FAILED_PRECONDITION
     */
     const RPC_GRPC_STATUS_CODE_FAILED_PRECONDITION = '9';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE ABORTED
     */
     const RPC_GRPC_STATUS_CODE_ABORTED = '10';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE OUT_OF_RANGE
     */
     const RPC_GRPC_STATUS_CODE_OUT_OF_RANGE = '11';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE UNIMPLEMENTED
     */
     const RPC_GRPC_STATUS_CODE_UNIMPLEMENTED = '12';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE INTERNAL
     */
     const RPC_GRPC_STATUS_CODE_INTERNAL = '13';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE UNAVAILABLE
     */
     const RPC_GRPC_STATUS_CODE_UNAVAILABLE = '14';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE DATA_LOSS
     */
     const RPC_GRPC_STATUS_CODE_DATA_LOSS = '15';

    /**
     * @see TraceAttributes::RPC_GRPC_STATUS_CODE UNAUTHENTICATED
     */
     const RPC_GRPC_STATUS_CODE_UNAUTHENTICATED = '16';

    /**
     * @see TraceAttributes::MESSAGE_TYPE sent
     */
     const MESSAGE_TYPE_SENT = 'SENT';

    /**
     * @see TraceAttributes::MESSAGE_TYPE received
     */
     const MESSAGE_TYPE_RECEIVED = 'RECEIVED';
}
