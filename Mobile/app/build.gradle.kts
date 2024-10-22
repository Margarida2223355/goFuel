plugins {
    alias(libs.plugins.android.application)
    alias(libs.plugins.google.services)
}

android {
    namespace = "com.example.gofuel"
    compileSdk = 34
    viewBinding {
        enable = true
    }

    defaultConfig {
        applicationId = "com.example.gofuel"
        minSdk = 24
        targetSdk = 34
        versionCode = 2
        versionName = "1.0"

        testInstrumentationRunner = "androidx.test.runner.AndroidJUnitRunner"
    }

    buildTypes {
        release {
            isMinifyEnabled = false
            proguardFiles(
                getDefaultProguardFile("proguard-android-optimize.txt"),
                "proguard-rules.pro"
            )
        }
    }
    compileOptions {
        sourceCompatibility = JavaVersion.VERSION_1_8
        targetCompatibility = JavaVersion.VERSION_1_8
    }
}

dependencies {

    implementation(libs.appcompat)
    implementation(libs.material)
    implementation(libs.activity)
    implementation(libs.constraintlayout)
    testImplementation(libs.junit)
    androidTestImplementation(libs.ext.junit)
    androidTestImplementation(libs.espresso.core)

    // Retrofit to API calls
    implementation(libs.retrofit2)
    implementation(libs.retrofit2Conversor)

    // Room for database
    implementation(libs.room.runtime)
    annotationProcessor(libs.room.compiler)

    // Gson
    implementation(libs.gson)

    // Firebase
    implementation(platform(libs.firebase))
}