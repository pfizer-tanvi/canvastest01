import sys
import argparse
import logging
import os
import json
import boto3
real_client = boto3.client('ecs', region_name='eu-west-1')


class ServiceUpdate:
    """ Update the related service so we can deploy the image """

    cluster = "cat-platform-staging"

    def __init__(self, client=False):
        self.client = client if client != False else real_client
        self.service_name_complete = None

    def update(self, name):
        print("Updating service ", name)
        self.service_name = name
        self.getServiceName()

        try:
            self.client.update_service(
                cluster=self.cluster,
                service=name,
                forceNewDeployment=True
            )
            return True
        except Exception as e:
            print("Error while sending request")
            print(e)
            return False

    def getServiceName(self):
        """using the root name we get the rest of it"""
        self.paginator = self.client.get_paginator("list_services")
        self.services = self.paginator.paginate(
            cluster=self.cluster
        )
        for services in self.services:
            for service in services['serviceArns']:
                print(service)
                if self.service_name in service:
                    self.name_split = service.split("/")[-1]
                    self.service_name_complete = self.name_split
                    return True

    def update_and_wait(self, name):
        print("Getting status for service ", name)

        try:
            print("Sending request will wait till done")
            print("This is the name found %s" % self.service_name_complete)
            self.service_name = name
            self.getServiceName()
            self.update(self.service_name_complete)

            waiter = self.client.get_waiter('services_stable')
            waiter.wait(
                cluster=self.cluster,
                services=[
                    self.service_name_complete,
                ],
                WaiterConfig={
                    'Delay': 20,
                    'MaxAttempts': 80
                }
            )
            return True
        except Exception as e:
            print("Error while sending request")
            print(e)
            return False


if __name__ == "__main__":
    """ run via command line """

    parser = argparse.ArgumentParser(description='Update named service')
    parser.add_argument('serviceName',
                        help='this is the name of the ECR service to push to')

    args = parser.parse_args()

    service = ServiceUpdate()
    print("Passed in name", args.serviceName)
    service.update_and_wait(args.serviceName)
