import os
import json
import boto3
import botocore.config
import time
import argparse

region = "eu-west-1"
if "AWS_REGION" in os.environ:
    region = os.environ.get("AWS_REGION")
client = boto3.client("codepipeline", region)


class CheckPipeline:
    def __init__(self):
        """ see if pipeline is pass or fail """
        self.pipeline_name = None
        self.job_id = None
        self.status = None

    def wait(self, name, job_id):
        """ wait for job to be done"""
        try:
            """ try and exit if done """
            results = self.check(name, job_id)
            if results == "Failed":
                raise Exception("Pipeline Deployment has Failed")
            elif results == "Succeeded":
                print("Deployment is Done")
                return True
            else:
                print("Still running")
                time.sleep(10)
                self.wait(name, job_id)

        except Exception as e:
            """ fail miserably if not """
            print("We have a failed job!")
            raise Exception(str(e))

    def check(self, name, job_id):
        """ check the status of the pipeline """
        try:
            print("Checking Job")
            response = client.get_pipeline_execution(
                pipelineName=name, pipelineExecutionId=job_id
            )
            self.status = response["pipelineExecution"]["status"]
            return self.status
        except Exception as e:
            print("Error", e)

    def execute(self, name):
        """ send job request """
        print("Triggering Job")
        response = client.start_pipeline_execution(name=name)
        self.job_id = response["pipelineExecutionId"]
        print("Job Started", self.job_id)
        return self.job_id


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Get and Wait for job")
    parser.add_argument("pipeline_name", help="This is the name of the pipeline")
    parser.add_argument("job_id", help="This is the job id", nargs="?")

    args = parser.parse_args()
    name = args.pipeline_name
    job_id = args.job_id
    print("Name", name)
    print("JobID", job_id)
    checker = CheckPipeline()
    if not job_id:
        print("no job id going to trigger first")
        job_id = checker.execute(name)
        results = checker.wait(name, job_id)
    else:
        results = checker.wait(name, job_id)
