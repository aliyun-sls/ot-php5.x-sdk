<?php

// DO NOT EDIT, this is an Auto-generated file from script/semantic-convention/templates/AttributeValues.php.j2



namespace OpenTelemetry\SemConv;

interface ResourceAttributeValues
{
    /**
     * The URL of the OpenTelemetry schema for these keys and values.
     */
    const SCHEMA_URL = 'https://opentelemetry.io/schemas/1.12.0';
    /**
     * @see ResourceAttributes::CLOUD_PROVIDER Alibaba Cloud
     */
    const CLOUD_PROVIDER_ALIBABA_CLOUD = 'alibaba_cloud';

    /**
     * @see ResourceAttributes::CLOUD_PROVIDER Amazon Web Services
     */
    const CLOUD_PROVIDER_AWS = 'aws';

    /**
     * @see ResourceAttributes::CLOUD_PROVIDER Microsoft Azure
     */
    const CLOUD_PROVIDER_AZURE = 'azure';

    /**
     * @see ResourceAttributes::CLOUD_PROVIDER Google Cloud Platform
     */
    const CLOUD_PROVIDER_GCP = 'gcp';

    /**
     * @see ResourceAttributes::CLOUD_PROVIDER Tencent Cloud
     */
    const CLOUD_PROVIDER_TENCENT_CLOUD = 'tencent_cloud';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Alibaba Cloud Elastic Compute Service
     */
    const CLOUD_PLATFORM_ALIBABA_CLOUD_ECS = 'alibaba_cloud_ecs';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Alibaba Cloud Function Compute
     */
    const CLOUD_PLATFORM_ALIBABA_CLOUD_FC = 'alibaba_cloud_fc';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM AWS Elastic Compute Cloud
     */
    const CLOUD_PLATFORM_AWS_EC2 = 'aws_ec2';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM AWS Elastic Container Service
     */
    const CLOUD_PLATFORM_AWS_ECS = 'aws_ecs';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM AWS Elastic Kubernetes Service
     */
    const CLOUD_PLATFORM_AWS_EKS = 'aws_eks';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM AWS Lambda
     */
    const CLOUD_PLATFORM_AWS_LAMBDA = 'aws_lambda';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM AWS Elastic Beanstalk
     */
    const CLOUD_PLATFORM_AWS_ELASTIC_BEANSTALK = 'aws_elastic_beanstalk';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM AWS App Runner
     */
    const CLOUD_PLATFORM_AWS_APP_RUNNER = 'aws_app_runner';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Azure Virtual Machines
     */
    const CLOUD_PLATFORM_AZURE_VM = 'azure_vm';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Azure Container Instances
     */
    const CLOUD_PLATFORM_AZURE_CONTAINER_INSTANCES = 'azure_container_instances';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Azure Kubernetes Service
     */
    const CLOUD_PLATFORM_AZURE_AKS = 'azure_aks';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Azure Functions
     */
    const CLOUD_PLATFORM_AZURE_FUNCTIONS = 'azure_functions';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Azure App Service
     */
    const CLOUD_PLATFORM_AZURE_APP_SERVICE = 'azure_app_service';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Google Cloud Compute Engine (GCE)
     */
    const CLOUD_PLATFORM_GCP_COMPUTE_ENGINE = 'gcp_compute_engine';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Google Cloud Run
     */
    const CLOUD_PLATFORM_GCP_CLOUD_RUN = 'gcp_cloud_run';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Google Cloud Kubernetes Engine (GKE)
     */
    const CLOUD_PLATFORM_GCP_KUBERNETES_ENGINE = 'gcp_kubernetes_engine';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Google Cloud Functions (GCF)
     */
    const CLOUD_PLATFORM_GCP_CLOUD_FUNCTIONS = 'gcp_cloud_functions';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Google Cloud App Engine (GAE)
     */
    const CLOUD_PLATFORM_GCP_APP_ENGINE = 'gcp_app_engine';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Tencent Cloud Cloud Virtual Machine (CVM)
     */
    const CLOUD_PLATFORM_TENCENT_CLOUD_CVM = 'tencent_cloud_cvm';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Tencent Cloud Elastic Kubernetes Service (EKS)
     */
    const CLOUD_PLATFORM_TENCENT_CLOUD_EKS = 'tencent_cloud_eks';

    /**
     * @see ResourceAttributes::CLOUD_PLATFORM Tencent Cloud Serverless Cloud Function (SCF)
     */
    const CLOUD_PLATFORM_TENCENT_CLOUD_SCF = 'tencent_cloud_scf';

    /**
     * @see ResourceAttributes::AWS_ECS_LAUNCHTYPE ec2
     */
    const AWS_ECS_LAUNCHTYPE_EC2 = 'ec2';

    /**
     * @see ResourceAttributes::AWS_ECS_LAUNCHTYPE fargate
     */
    const AWS_ECS_LAUNCHTYPE_FARGATE = 'fargate';

    /**
     * @see ResourceAttributes::HOST_ARCH AMD64
     */
    const HOST_ARCH_AMD64 = 'amd64';

    /**
     * @see ResourceAttributes::HOST_ARCH ARM32
     */
    const HOST_ARCH_ARM32 = 'arm32';

    /**
     * @see ResourceAttributes::HOST_ARCH ARM64
     */
    const HOST_ARCH_ARM64 = 'arm64';

    /**
     * @see ResourceAttributes::HOST_ARCH Itanium
     */
    const HOST_ARCH_IA64 = 'ia64';

    /**
     * @see ResourceAttributes::HOST_ARCH 32-bit PowerPC
     */
    const HOST_ARCH_PPC32 = 'ppc32';

    /**
     * @see ResourceAttributes::HOST_ARCH 64-bit PowerPC
     */
    const HOST_ARCH_PPC64 = 'ppc64';

    /**
     * @see ResourceAttributes::HOST_ARCH IBM z/Architecture
     */
    const HOST_ARCH_S390X = 's390x';

    /**
     * @see ResourceAttributes::HOST_ARCH 32-bit x86
     */
    const HOST_ARCH_X86 = 'x86';

    /**
     * @see ResourceAttributes::OS_TYPE Microsoft Windows
     */
    const OS_TYPE_WINDOWS = 'windows';

    /**
     * @see ResourceAttributes::OS_TYPE Linux
     */
    const OS_TYPE_LINUX = 'linux';

    /**
     * @see ResourceAttributes::OS_TYPE Apple Darwin
     */
    const OS_TYPE_DARWIN = 'darwin';

    /**
     * @see ResourceAttributes::OS_TYPE FreeBSD
     */
    const OS_TYPE_FREEBSD = 'freebsd';

    /**
     * @see ResourceAttributes::OS_TYPE NetBSD
     */
    const OS_TYPE_NETBSD = 'netbsd';

    /**
     * @see ResourceAttributes::OS_TYPE OpenBSD
     */
    const OS_TYPE_OPENBSD = 'openbsd';

    /**
     * @see ResourceAttributes::OS_TYPE DragonFly BSD
     */
    const OS_TYPE_DRAGONFLYBSD = 'dragonflybsd';

    /**
     * @see ResourceAttributes::OS_TYPE HP-UX (Hewlett Packard Unix)
     */
    const OS_TYPE_HPUX = 'hpux';

    /**
     * @see ResourceAttributes::OS_TYPE AIX (Advanced Interactive eXecutive)
     */
    const OS_TYPE_AIX = 'aix';

    /**
     * @see ResourceAttributes::OS_TYPE SunOS, Oracle Solaris
     */
    const OS_TYPE_SOLARIS = 'solaris';

    /**
     * @see ResourceAttributes::OS_TYPE IBM z/OS
     */
    const OS_TYPE_Z_OS = 'z_os';

    /**
     * @see ResourceAttributes::TELEMETRY_SDK_LANGUAGE cpp
     */
    const TELEMETRY_SDK_LANGUAGE_CPP = 'cpp';

    /**
     * @see ResourceAttributes::TELEMETRY_SDK_LANGUAGE dotnet
     */
    const TELEMETRY_SDK_LANGUAGE_DOTNET = 'dotnet';

    /**
     * @see ResourceAttributes::TELEMETRY_SDK_LANGUAGE erlang
     */
    const TELEMETRY_SDK_LANGUAGE_ERLANG = 'erlang';

    /**
     * @see ResourceAttributes::TELEMETRY_SDK_LANGUAGE go
     */
    const TELEMETRY_SDK_LANGUAGE_GO = 'go';

    /**
     * @see ResourceAttributes::TELEMETRY_SDK_LANGUAGE java
     */
    const TELEMETRY_SDK_LANGUAGE_JAVA = 'java';

    /**
     * @see ResourceAttributes::TELEMETRY_SDK_LANGUAGE nodejs
     */
    const TELEMETRY_SDK_LANGUAGE_NODEJS = 'nodejs';

    /**
     * @see ResourceAttributes::TELEMETRY_SDK_LANGUAGE php
     */
    const TELEMETRY_SDK_LANGUAGE_PHP = 'php';

    /**
     * @see ResourceAttributes::TELEMETRY_SDK_LANGUAGE python
     */
    const TELEMETRY_SDK_LANGUAGE_PYTHON = 'python';

    /**
     * @see ResourceAttributes::TELEMETRY_SDK_LANGUAGE ruby
     */
    const TELEMETRY_SDK_LANGUAGE_RUBY = 'ruby';

    /**
     * @see ResourceAttributes::TELEMETRY_SDK_LANGUAGE webjs
     */
    const TELEMETRY_SDK_LANGUAGE_WEBJS = 'webjs';

    /**
     * @see ResourceAttributes::TELEMETRY_SDK_LANGUAGE swift
     */
    const TELEMETRY_SDK_LANGUAGE_SWIFT = 'swift';
}
