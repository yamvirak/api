pipeline {
    agent any
    environment {
        TELEGRAM_TOKEN = credentials('TOKEN')
        CHAT_ID    = credentials('CHAT_ID')
    }

    stages {
        stage('Test') {
            steps {
                echo 'Hello World'
            }
        }
         stage('Deploy') {
            steps {
                   sh 'ssh -o StrictHostKeyChecking=no root@139.59.104.63 "cd ../var/www/pos/api;\
                git pull;\
                cd ..;\
                "'
            }
        }
    }
      post{
    success{

        sh ''' 
        curl -s -X POST https://api.telegram.org/bot${TELEGRAM_TOKEN}/sendMessage -d chat_id=${CHAT_ID} -d parse_mode="HTML" -d text="<b>Stage</b> : JENKINS POS \n<b>Status</b> : <i>Success</i> \n<b>Version</b>: ${BUILD_NUMBER} <b> \nEnvironment </b> : Development"
        '''
    }
    failure{
        sh ''' 
        curl -s -X POST https://api.telegram.org/bot${TELEGRAM_TOKEN}/sendMessage -d chat_id=${CHAT_ID} -d parse_mode="HTML" -d text="<b>Stage</b> : JENKINS POS \n<b>Status</b> : <i>Failed</i> \n<b>Version</b>: ${BUILD_NUMBER} <b> \nEnvironment </b> : Development"
        '''
    }
    }
}